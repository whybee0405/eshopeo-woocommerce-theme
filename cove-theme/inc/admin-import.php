<?php
/**
 * COVE demo data importer — Appearance > Import Demo Data.
 * Idempotent: checks for existing products before inserting.
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;

function cove_admin_import_menu() {
	add_theme_page(
		__( 'Import Demo Data', 'cove' ),
		__( 'Import Demo Data', 'cove' ),
		'manage_options',
		'cove-import',
		'cove_admin_import_page'
	);
}
add_action( 'admin_menu', 'cove_admin_import_menu' );

function cove_admin_import_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'COVE — Import Demo Data', 'cove' ); ?></h1>
		<p><?php esc_html_e( 'Imports ~16 demo products across all categories and conditions. Idempotent — safe to run multiple times.', 'cove' ); ?></p>

		<?php
		if ( isset( $_POST['cove_import_nonce'] ) && wp_verify_nonce( $_POST['cove_import_nonce'], 'cove_import' ) ) {
			$result = cove_run_import();
			if ( is_wp_error( $result ) ) {
				echo '<div class="notice notice-error"><p>' . esc_html( $result->get_error_message() ) . '</p></div>';
			} else {
				echo '<div class="notice notice-success"><p>' . esc_html( sprintf( __( 'Done. %d products created, %d skipped (already exist).', 'cove' ), $result['created'], $result['skipped'] ) ) . '</p></div>';
			}
		}
		?>

		<form method="post">
			<?php wp_nonce_field( 'cove_import', 'cove_import_nonce' ); ?>
			<p><input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Run import', 'cove' ); ?>"></p>
		</form>
	</div>
	<?php
}

function cove_run_import(): array|\WP_Error {
	if ( ! function_exists( 'wc_get_products' ) ) {
		return new \WP_Error( 'no_wc', 'WooCommerce is not active.' );
	}

	$dummies_file = get_theme_file_path( 'dummy-products.php' );
	if ( ! file_exists( $dummies_file ) ) {
		return new \WP_Error( 'no_dummies', 'dummy-products.php not found.' );
	}
	require_once $dummies_file;

	if ( ! function_exists( 'cove_dummy_products' ) ) {
		return new \WP_Error( 'no_fn', 'cove_dummy_products() not defined.' );
	}

	$products = cove_dummy_products();
	$created  = 0;
	$skipped  = 0;

	foreach ( $products as $data ) {
		// Skip if title already exists as a product.
		$existing = get_posts( array(
			'post_type'   => 'product',
			'post_status' => 'publish',
			'title'       => $data['name'],
			'numberposts' => 1,
			'fields'      => 'ids',
		) );

		if ( ! empty( $existing ) ) {
			$skipped++;
			continue;
		}

		// Ensure category term exists.
		$cat_term = term_exists( $data['cat'], 'product_cat' );
		if ( ! $cat_term ) {
			$cat_term = wp_insert_term( ucwords( str_replace( '-', ' ', $data['cat'] ) ), 'product_cat', array( 'slug' => $data['cat'] ) );
		}
		$cat_id = is_array( $cat_term ) ? (int) $cat_term['term_id'] : 0;

		// Ensure condition term exists.
		$cond_labels = array(
			'new'     => 'New',
			'grade-a' => 'Grade A',
			'grade-b' => 'Grade B',
			'grade-c' => 'Grade C',
		);
		$cond_label = $cond_labels[ $data['condition'] ] ?? ucwords( str_replace( '-', ' ', $data['condition'] ) );
		$cond_term  = term_exists( $data['condition'], 'product_condition' );
		if ( ! $cond_term ) {
			$cond_term = wp_insert_term( $cond_label, 'product_condition', array( 'slug' => $data['condition'] ) );
		}
		$cond_id = is_array( $cond_term ) ? (int) $cond_term['term_id'] : 0;

		// Ensure brand term exists.
		$brand_term = term_exists( sanitize_title( $data['brand'] ), 'product_brand' );
		if ( ! $brand_term ) {
			$brand_term = wp_insert_term( $data['brand'], 'product_brand', array( 'slug' => sanitize_title( $data['brand'] ) ) );
		}

		// Create WC product.
		$product = new \WC_Product_Simple();
		$product->set_name( $data['name'] );
		$product->set_status( 'publish' );
		$product->set_description( $data['desc'] );
		$product->set_short_description( $data['desc'] );
		$product->set_regular_price( (string) $data['rrp'] );
		$product->set_category_ids( $cat_id ? array( $cat_id ) : array() );
		$product->set_manage_stock( false );
		$product->set_stock_status( 'instock' );
		$product->set_sold_individually( false );

		if ( $data['price'] < $data['rrp'] ) {
			$product->set_sale_price( (string) $data['price'] );
		}

		$pid = $product->save();
		if ( ! $pid || is_wp_error( $pid ) ) { continue; }

		// Assign condition taxonomy.
		if ( $cond_id ) {
			wp_set_object_terms( $pid, $cond_id, 'product_condition' );
		}

		// Assign brand taxonomy.
		if ( ! is_wp_error( $brand_term ) ) {
			wp_set_object_terms( $pid, (int) ( is_array( $brand_term ) ? $brand_term['term_id'] : $brand_term ), 'product_brand' );
		}

		// Custom meta fields.
		$metas = array(
			'_cove_brand'         => $data['brand'],
			'_cove_rrp'           => $data['rrp'],
			'_cove_energy_rating' => $data['energy'],
			'_cove_colour'        => $data['colour'],
			'_cove_warranty'      => $data['warranty'],
			'_cove_grade_notes'   => $data['grade_note'],
			'_cove_dimensions'    => $data['dims'],
			'_cove_weight'        => $data['weight'],
		);

		foreach ( $metas as $key => $value ) {
			update_post_meta( $pid, $key, $value );
		}

		// Compute and store saving amount.
		$saving = ( $data['rrp'] > $data['price'] ) ? round( $data['rrp'] - $data['price'] ) : 0;
		update_post_meta( $pid, '_cove_saving', $saving );

		// Sideload product image from URL into WP media library.
		if ( ! empty( $data['image'] ) ) {
			if ( ! function_exists( 'media_sideload_image' ) ) {
				require_once ABSPATH . 'wp-admin/includes/media.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/image.php';
			}
			$att_id = media_sideload_image( $data['image'], $pid, $data['name'], 'id' );
			if ( $att_id && ! is_wp_error( $att_id ) ) {
				set_post_thumbnail( $pid, $att_id );
				// Add to WC product gallery.
				update_post_meta( $pid, '_product_image_gallery', '' );
			}
		}

		$created++;
	}

	return array( 'created' => $created, 'skipped' => $skipped );
}
