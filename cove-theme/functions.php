<?php
/**
 * COVE Home Appliances — theme core.
 *
 * Full-cart WooCommerce theme. Products are purchasable with standard
 * cart + checkout flow. Grade A/B/C b-stock differentiated by
 * product_condition taxonomy + _cove_grade_notes meta.
 *
 * @package COVE
 */

defined( 'ABSPATH' ) || exit;

define( 'COVE_VERSION', '1.0.0' );

/* -------------------------------------------------------------------------
 * 1. Theme setup
 * ---------------------------------------------------------------------- */
function cove_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'style', 'script',
	) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( array(
		'primary' => __( 'Primary', 'cove' ),
		'footer'  => __( 'Footer', 'cove' ),
	) );

	add_image_size( 'cove-card', 600, 600, true );
	load_theme_textdomain( 'cove', get_theme_file_path( 'languages' ) );
}
add_action( 'after_setup_theme', 'cove_setup' );

/* -------------------------------------------------------------------------
 * 2. Enqueue assets
 * ---------------------------------------------------------------------- */
function cove_enqueue() {
	// Google Fonts — Fraunces, Plus Jakarta Sans, DM Mono.
	wp_enqueue_style(
		'cove-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300..900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	$style_path = get_theme_file_path( 'style.css' );
	wp_enqueue_style(
		'cove-style',
		get_stylesheet_uri(),
		array( 'cove-fonts' ),
		file_exists( $style_path ) ? filemtime( $style_path ) : COVE_VERSION
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$wc_path = get_theme_file_path( 'css/woocommerce.css' );
		wp_enqueue_style(
			'cove-woocommerce',
			get_theme_file_uri( 'css/woocommerce.css' ),
			array( 'cove-style' ),
			file_exists( $wc_path ) ? filemtime( $wc_path ) : COVE_VERSION
		);
	}

	// Disable WC's own CSS — we ship our own.
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	// GSAP + ScrollTrigger (CDN, footer, all pages).
	wp_enqueue_script( 'gsap',    'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',            array(), null, true );
	wp_enqueue_script( 'gsap-st', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), null, true );

	$scroll_path = get_theme_file_path( 'js/scroll-animations.js' );
	wp_enqueue_script(
		'cove-scroll-anim',
		get_theme_file_uri( 'js/scroll-animations.js' ),
		array( 'gsap', 'gsap-st' ),
		file_exists( $scroll_path ) ? filemtime( $scroll_path ) : COVE_VERSION,
		true
	);

	$main_path = get_theme_file_path( 'js/main.js' );
	wp_enqueue_script(
		'cove-main',
		get_theme_file_uri( 'js/main.js' ),
		array( 'cove-scroll-anim' ),
		file_exists( $main_path ) ? filemtime( $main_path ) : COVE_VERSION,
		true
	);

	wp_localize_script( 'cove-main', 'coveData', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'cove_nonce' ),
	) );

	// Catalogue filters JS — archive only.
	if ( is_post_type_archive( 'product' ) || is_product_category() || is_shop() ) {
		$filters_path = get_theme_file_path( 'js/filters.js' );
		wp_enqueue_script(
			'cove-filters',
			get_theme_file_uri( 'js/filters.js' ),
			array( 'cove-main' ),
			file_exists( $filters_path ) ? filemtime( $filters_path ) : COVE_VERSION,
			true
		);
	}

	// Three.js hero — front page only (module script).
	if ( is_front_page() ) {
		$hero_path = get_theme_file_path( 'js/hero-room.js' );
		wp_enqueue_script(
			'cove-hero-room',
			get_theme_file_uri( 'js/hero-room.js' ),
			array(),
			file_exists( $hero_path ) ? filemtime( $hero_path ) : COVE_VERSION,
			true
		);
	}

	// Three.js PDP viewer — single product only (module script).
	if ( is_singular( 'product' ) ) {
		$pdp_path = get_theme_file_path( 'js/pdp-3d.js' );
		wp_enqueue_script(
			'cove-pdp-3d',
			get_theme_file_uri( 'js/pdp-3d.js' ),
			array(),
			file_exists( $pdp_path ) ? filemtime( $pdp_path ) : COVE_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'cove_enqueue' );

// Make cove-hero-room and cove-pdp-3d load as type="module".
function cove_module_script_type( $tag, $handle, $src ) {
	$modules = array( 'cove-hero-room', 'cove-pdp-3d' );
	if ( in_array( $handle, $modules, true ) ) {
		return '<script type="module" src="' . esc_url( $src ) . '"></script>' . "\n";
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'cove_module_script_type', 10, 3 );

// Importmap — required before any type="module" that bare-imports "three".
function cove_importmap() {
	if ( is_front_page() || is_singular( 'product' ) ) {
		echo '<script type="importmap">{"imports":{"three":"https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js","three/addons/":"https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"}}</script>' . "\n";
	}
}
add_action( 'wp_head', 'cove_importmap', 1 );

// JS feature flag (enables CSS reveal styles).
function cove_js_flag() {
	echo "<script>document.documentElement.classList.add('js');</script>\n";
}
add_action( 'wp_head', 'cove_js_flag', 0 );

// Preconnect to Google Fonts asset host.
function cove_preconnect( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && wp_style_is( 'cove-fonts', 'enqueued' ) ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'cove_preconnect', 10, 2 );

/* -------------------------------------------------------------------------
 * 3. Taxonomies
 * ---------------------------------------------------------------------- */
function cove_register_taxonomies() {
	$taxes = array(
		'product_condition' => array(
			'slug'   => 'condition',
			'single' => __( 'Condition', 'cove' ),
			'plural' => __( 'Conditions', 'cove' ),
		),
		'product_brand' => array(
			'slug'   => 'brand',
			'single' => __( 'Brand', 'cove' ),
			'plural' => __( 'Brands', 'cove' ),
		),
	);

	foreach ( $taxes as $taxonomy => $args ) {
		register_taxonomy( $taxonomy, 'product', array(
			'labels' => array(
				'name'          => $args['plural'],
				'singular_name' => $args['single'],
				'menu_name'     => $args['plural'],
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $args['slug'] ),
		) );
	}
}
add_action( 'init', 'cove_register_taxonomies' );

/* -------------------------------------------------------------------------
 * 4. Product meta
 * ---------------------------------------------------------------------- */
function cove_meta_definitions() {
	return array(
		'_cove_brand'        => array( 'type' => 'string' ),
		'_cove_rrp'          => array( 'type' => 'number' ),
		'_cove_energy_rating'=> array( 'type' => 'string' ),
		'_cove_colour'       => array( 'type' => 'string' ),
		'_cove_warranty'     => array( 'type' => 'string' ),
		'_cove_grade_notes'  => array( 'type' => 'string' ),
		'_cove_dimensions'   => array( 'type' => 'string' ),
		'_cove_weight'       => array( 'type' => 'number' ),
		'_cove_saving'       => array( 'type' => 'number' ),
	);
}

function cove_register_meta() {
	$auth = function() { return current_user_can( 'edit_products' ); };
	foreach ( cove_meta_definitions() as $key => $def ) {
		register_post_meta( 'product', $key, array(
			'single'        => true,
			'type'          => $def['type'],
			'show_in_rest'  => true,
			'auth_callback' => $auth,
		) );
	}
}
add_action( 'init', 'cove_register_meta' );

// Auto-compute _cove_saving when a product is saved.
function cove_compute_saving( $product_id ) {
	$product = wc_get_product( $product_id );
	if ( ! $product ) { return; }
	$rrp   = (float) get_post_meta( $product_id, '_cove_rrp', true );
	$price = (float) $product->get_sale_price() ?: (float) $product->get_regular_price();
	$saving = ( $rrp > 0 && $price > 0 && $rrp > $price ) ? round( $rrp - $price ) : 0;
	update_post_meta( $product_id, '_cove_saving', $saving );
}
add_action( 'woocommerce_process_product_meta', 'cove_compute_saving' );

/* -------------------------------------------------------------------------
 * 5. WC global attributes (idempotent)
 * ---------------------------------------------------------------------- */
function cove_register_global_attributes() {
	if ( ! function_exists( 'wc_create_attribute' ) ) { return; }
	if ( ! is_admin() && get_option( 'cove_attributes_ready' ) ) { return; }

	$wanted = array(
		'condition' => __( 'Condition', 'cove' ),
		'brand'     => __( 'Brand', 'cove' ),
		'category'  => __( 'Category', 'cove' ),
		'energy'    => __( 'Energy Rating', 'cove' ),
	);

	$existing = array();
	foreach ( wc_get_attribute_taxonomies() as $tax ) {
		$existing[ $tax->attribute_name ] = true;
	}

	$created = false;
	foreach ( $wanted as $slug => $label ) {
		if ( isset( $existing[ $slug ] ) ) { continue; }
		$result = wc_create_attribute( array(
			'name'         => $label,
			'slug'         => $slug,
			'type'         => 'select',
			'order_by'     => 'name',
			'has_archives' => false,
		) );
		if ( ! is_wp_error( $result ) ) { $created = true; }
	}

	if ( $created ) { delete_transient( 'wc_attribute_taxonomies' ); }
	update_option( 'cove_attributes_ready', 1 );
}
add_action( 'init', 'cove_register_global_attributes', 20 );

/* -------------------------------------------------------------------------
 * 6. WooCommerce configuration
 * ---------------------------------------------------------------------- */
// 12 products per archive page.
add_filter( 'loop_shop_per_page', function() { return 12; }, 20 );

// 1 column so WC adds columns-1 class; CSS grid controls visual columns.
add_filter( 'loop_shop_columns', function() { return 1; } );

// Breadcrumb delimiter.
add_filter( 'woocommerce_breadcrumb_defaults', function( $d ) {
	$d['delimiter'] = ' <span class="breadcrumb-sep" aria-hidden="true">&rsaquo;</span> ';
	return $d;
} );

// Remove WC default chrome we render ourselves.
function cove_strip_wc_chrome() {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
}
add_action( 'init', 'cove_strip_wc_chrome' );

// Render custom page title on shop archive.
add_filter( 'woocommerce_show_page_title', '__return_false' );

/* -------------------------------------------------------------------------
 * 7. Faceted catalogue — pre_get_posts
 * ---------------------------------------------------------------------- */
function cove_apply_catalogue_filters( \WP_Query $q ) {
	if ( is_admin() || ! $q->is_main_query() ) { return; }

	$is_catalogue = ( function_exists( 'is_shop' ) && is_shop() )
		|| ( function_exists( 'is_post_type_archive' ) && is_post_type_archive( 'product' ) )
		|| ( function_exists( 'is_product_category' ) && is_product_category() )
		|| ( function_exists( 'is_tax' ) && is_tax( array( 'product_condition', 'product_brand' ) ) );

	if ( ! $is_catalogue ) { return; }

	$get_str = static function( $key ) {
		return isset( $_GET[ $key ] ) && '' !== $_GET[ $key ] // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			? sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			: '';
	};
	$get_int = static function( $key ) {
		return isset( $_GET[ $key ] ) && '' !== $_GET[ $key ] // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			? intval( wp_unslash( $_GET[ $key ] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			: null;
	};

	/* --- tax_query -------------------------------------------------------- */
	$tax_query = array();

	$condition = $get_str( 'condition' );
	if ( '' !== $condition ) {
		$tax_query[] = array(
			'taxonomy' => 'product_condition',
			'field'    => 'slug',
			'terms'    => array( sanitize_title( $condition ) ),
		);
	}

	$brand = $get_str( 'brand' );
	if ( '' !== $brand ) {
		$tax_query[] = array(
			'taxonomy' => 'product_brand',
			'field'    => 'slug',
			'terms'    => array( sanitize_title( $brand ) ),
		);
	}

	$cat = $get_str( 'cat' );
	if ( '' !== $cat ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array( sanitize_title( $cat ) ),
		);
	}

	if ( ! empty( $tax_query ) ) {
		if ( count( $tax_query ) > 1 ) { $tax_query['relation'] = 'AND'; }
		$existing = $q->get( 'tax_query' );
		if ( ! empty( $existing ) && is_array( $existing ) ) {
			$tax_query = array( 'relation' => 'AND', $existing, $tax_query );
		}
		$q->set( 'tax_query', $tax_query );
	}

	/* --- meta_query ------------------------------------------------------- */
	$meta_query = array();

	$price_min = $get_int( 'price_min' );
	$price_max = $get_int( 'price_max' );

	if ( null !== $price_min && null !== $price_max ) {
		$meta_query[] = array( 'key' => '_price', 'value' => array( $price_min, $price_max ), 'type' => 'NUMERIC', 'compare' => 'BETWEEN' );
	} elseif ( null !== $price_min ) {
		$meta_query[] = array( 'key' => '_price', 'value' => $price_min, 'type' => 'NUMERIC', 'compare' => '>=' );
	} elseif ( null !== $price_max ) {
		$meta_query[] = array( 'key' => '_price', 'value' => $price_max, 'type' => 'NUMERIC', 'compare' => '<=' );
	}

	$energy = $get_str( 'energy' );
	if ( '' !== $energy ) {
		$meta_query[] = array( 'key' => '_cove_energy_rating', 'value' => $energy, 'compare' => '=' );
	}

	if ( ! empty( $meta_query ) ) {
		if ( count( $meta_query ) > 1 ) { $meta_query['relation'] = 'AND'; }
		$existing = $q->get( 'meta_query' );
		if ( ! empty( $existing ) && is_array( $existing ) ) {
			$meta_query = array( 'relation' => 'AND', $existing, $meta_query );
		}
		$q->set( 'meta_query', $meta_query );
	}

	/* --- ordering --------------------------------------------------------- */
	$orderby = $get_str( 'orderby' );
	switch ( $orderby ) {
		case 'price':
			$q->set( 'orderby', 'meta_value_num' );
			$q->set( 'meta_key', '_price' );
			$q->set( 'order', 'ASC' );
			break;
		case 'price-desc':
			$q->set( 'orderby', 'meta_value_num' );
			$q->set( 'meta_key', '_price' );
			$q->set( 'order', 'DESC' );
			break;
		case 'saving':
			$q->set( 'orderby', 'meta_value_num' );
			$q->set( 'meta_key', '_cove_saving' );
			$q->set( 'order', 'DESC' );
			break;
		case 'date':
			$q->set( 'orderby', 'date' );
			$q->set( 'order', 'DESC' );
			break;
	}
}
add_action( 'pre_get_posts', 'cove_apply_catalogue_filters' );

/* -------------------------------------------------------------------------
 * 8. Helper functions
 * ---------------------------------------------------------------------- */

/**
 * Thin wrapper over get_post_meta().
 */
function cove_meta( int $id, string $key ) {
	return get_post_meta( $id, $key, true );
}

/**
 * Condition slug → human label.
 */
function cove_condition_label( string $slug ): string {
	$labels = array(
		'new'     => __( 'New', 'cove' ),
		'grade-a' => __( 'Grade A', 'cove' ),
		'grade-b' => __( 'Grade B', 'cove' ),
		'grade-c' => __( 'Grade C', 'cove' ),
	);
	return $labels[ $slug ] ?? ucwords( str_replace( '-', ' ', $slug ) );
}

/**
 * Condition slug → badge CSS class.
 */
function cove_condition_class( string $slug ): string {
	$map = array(
		'new'     => 'badge-new',
		'grade-a' => 'badge-grade-a',
		'grade-b' => 'badge-grade-b',
		'grade-c' => 'badge-grade-c',
	);
	return $map[ $slug ] ?? 'badge-new';
}

/**
 * Return the saving amount for a product (RRP − current price).
 */
function cove_saving( int $id ): float {
	$saved = (float) cove_meta( $id, '_cove_saving' );
	if ( $saved > 0 ) { return $saved; }

	$rrp   = (float) cove_meta( $id, '_cove_rrp' );
	$price = (float) get_post_meta( $id, '_price', true );
	return ( $rrp > 0 && $price > 0 && $rrp > $price ) ? round( $rrp - $price ) : 0;
}

/**
 * Return primary condition term slug for a product.
 */
function cove_product_condition( int $id ): string {
	$terms = get_the_terms( $id, 'product_condition' );
	if ( ! $terms || is_wp_error( $terms ) ) { return 'new'; }
	return $terms[0]->slug;
}

/**
 * Return category slugs array for a product.
 */
function cove_categories(): array {
	return array(
		'kitchen'     => array( 'label' => __( 'Kitchen', 'cove' ),     'icon' => get_theme_file_uri( 'images/icons/cat-kitchen.svg' ) ),
		'laundry'     => array( 'label' => __( 'Laundry', 'cove' ),     'icon' => get_theme_file_uri( 'images/icons/cat-laundry.svg' ) ),
		'climate'     => array( 'label' => __( 'Climate', 'cove' ),     'icon' => get_theme_file_uri( 'images/icons/cat-climate.svg' ) ),
		'floor-care'  => array( 'label' => __( 'Floor Care', 'cove' ),  'icon' => get_theme_file_uri( 'images/icons/cat-floorcare.svg' ) ),
		'personal-care' => array( 'label' => __( 'Personal Care', 'cove' ), 'icon' => get_theme_file_uri( 'images/icons/cat-personal.svg' ) ),
	);
}

/**
 * Echo a blog post card.
 */
function cove_post_card( $post = null ): void {
	$post = get_post( $post );
	if ( ! $post ) { return; }
	$id        = $post->ID;
	$permalink = get_permalink( $id );
	$cats      = get_the_category( $id );
	$content   = get_post_field( 'post_content', $id );
	$words     = str_word_count( wp_strip_all_tags( (string) $content ) );
	$read_time = max( 1, (int) ceil( $words / 200 ) );
	$excerpt   = wp_trim_words( get_the_excerpt( $id ), 20 );
	?>
	<article class="post-card">
		<?php if ( has_post_thumbnail( $id ) ) : ?>
			<a class="post-card__media" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
				<?php echo get_the_post_thumbnail( $id, 'cove-card' ); // phpcs:ignore ?>
			</a>
		<?php endif; ?>
		<div class="post-card__body stack-sm">
			<?php if ( ! empty( $cats ) ) : ?>
				<span class="eyebrow post-card__cat"><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
			<h3 class="post-card__title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?></a></h3>
			<p class="t-mono muted post-card__meta">
				<?php echo esc_html( get_the_date( '', $id ) ); ?>
				<span aria-hidden="true">&middot;</span>
				<?php printf( esc_html( _n( '%d min read', '%d min read', $read_time, 'cove' ) ), (int) $read_time ); ?>
			</p>
			<?php if ( '' !== $excerpt ) : ?>
				<p class="muted"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>
			<a class="link-arrow" href="<?php echo esc_url( $permalink ); ?>"><?php esc_html_e( 'Read', 'cove' ); ?></a>
		</div>
	</article>
	<?php
}

/* -------------------------------------------------------------------------
 * 9. AJAX — contact form
 * ---------------------------------------------------------------------- */
function cove_ajax_contact() {
	check_ajax_referer( 'cove_nonce', 'nonce' );

	$name    = isset( $_POST['name'] )    ? sanitize_text_field( wp_unslash( $_POST['name'] ) )    : '';
	$email   = isset( $_POST['email'] )   ? sanitize_email( wp_unslash( $_POST['email'] ) )        : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name ) {
		wp_send_json_error( array( 'message' => __( 'Please enter your name.', 'cove' ) ) );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'cove' ) ) );
	}
	if ( '' === $message ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a message.', 'cove' ) ) );
	}

	$subject = sprintf( __( 'COVE enquiry from %s', 'cove' ), $name );
	$body    = implode( "\n", array( "Name: $name", "Email: $email", '', $message ) );
	wp_mail( get_option( 'admin_email' ), $subject, $body );

	wp_send_json_success( array( 'message' => __( 'Thanks! We\'ll be in touch within one business day.', 'cove' ) ) );
}
add_action( 'wp_ajax_cove_contact', 'cove_ajax_contact' );
add_action( 'wp_ajax_nopriv_cove_contact', 'cove_ajax_contact' );

/* -------------------------------------------------------------------------
 * 10. Load modules
 * ---------------------------------------------------------------------- */
$cove_seo    = get_theme_file_path( 'inc/seo.php' );
$cove_import = get_theme_file_path( 'inc/admin-import.php' );

if ( file_exists( $cove_seo ) ) { require_once $cove_seo; }
if ( is_admin() && file_exists( $cove_import ) ) { require_once $cove_import; }
