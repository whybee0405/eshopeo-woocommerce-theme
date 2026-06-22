<?php
/**
 * COVE product detail page.
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	global $product;
	if ( ! is_a( $product, 'WC_Product' ) ) { $product = wc_get_product( get_the_ID() ); }

	$pid         = $product->get_id();
	$brand       = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_brand' )        : '';
	$condition   = function_exists( 'cove_product_condition' ) ? cove_product_condition( $pid )       : 'new';
	$cond_label  = function_exists( 'cove_condition_label' )   ? cove_condition_label( $condition )   : 'New';
	$cond_class  = function_exists( 'cove_condition_class' )   ? cove_condition_class( $condition )   : 'badge-new';
	$grade_note  = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_grade_notes' )  : '';
	$warranty    = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_warranty' )     : '';
	$energy      = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_energy_rating' ): '';
	$dims        = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_dimensions' )   : '';
	$weight      = function_exists( 'cove_meta' ) ? (float)  cove_meta( $pid, '_cove_weight' )       : 0;
	$colour      = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_colour' )       : '';
	$rrp         = function_exists( 'cove_meta' ) ? (float)  cove_meta( $pid, '_cove_rrp' )          : 0;
	$saving      = function_exists( 'cove_saving' ) ? cove_saving( $pid )                            : 0;
	$gallery_ids = $product->get_gallery_image_ids();
	$has_image   = has_post_thumbnail( $pid );

	// Determine product category for 3D viewer mesh type.
	$cat_terms    = get_the_terms( $pid, 'product_cat' );
	$pdp_category = ( $cat_terms && ! is_wp_error( $cat_terms ) ) ? $cat_terms[0]->slug : 'kitchen';
	?>

	<main id="main">
		<div class="container">
			<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) { woocommerce_breadcrumb(); } ?>
			<?php if ( function_exists( 'wc_print_notices' ) ) { wc_print_notices(); } ?>

			<div class="pdp-grid">

				<!-- Gallery column -->
				<div class="pdp-gallery">
					<div class="pdp-gallery__wrap">
						<div class="pdp-main-image"
							id="cove-pdp-3d-wrap"
							data-has-image="<?php echo $has_image ? 'true' : 'false'; ?>"
							data-category="<?php echo esc_attr( $pdp_category ); ?>">

							<?php if ( $has_image ) : ?>
								<figure data-pdp-main>
									<?php echo get_the_post_thumbnail( $pid, 'large', array( 'loading' => 'eager' ) ); // phpcs:ignore ?>
								</figure>
							<?php endif; ?>

							<canvas id="cove-pdp-canvas" aria-hidden="true" role="presentation" <?php echo $has_image ? 'hidden' : ''; ?>></canvas>

							<button class="btn-view-3d" id="cove-view-3d-btn" type="button">
								<?php esc_html_e( 'View 3D', 'cove' ); ?>
							</button>
						</div>

						<?php if ( ! empty( $gallery_ids ) ) : ?>
							<div class="pdp-thumbs" role="group" aria-label="<?php esc_attr_e( 'Product images', 'cove' ); ?>">
								<?php if ( $has_image ) : ?>
									<button class="pdp-thumb is-active" type="button"
										data-full="<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id( $pid ), 'large' ) ); ?>">
										<?php echo get_the_post_thumbnail( $pid, 'thumbnail' ); // phpcs:ignore ?>
									</button>
								<?php endif; ?>
								<?php foreach ( $gallery_ids as $gid ) : ?>
									<button class="pdp-thumb" type="button"
										data-full="<?php echo esc_url( wp_get_attachment_image_url( $gid, 'large' ) ); ?>">
										<?php echo wp_get_attachment_image( $gid, 'thumbnail' ); // phpcs:ignore ?>
									</button>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<!-- Info column -->
				<div class="pdp-info stack">

					<?php if ( '' !== $brand ) : ?>
						<p class="pdp-brand"><?php echo esc_html( $brand ); ?></p>
					<?php endif; ?>

					<h1 class="pdp-title"><?php echo esc_html( $product->get_name() ); ?></h1>

					<span class="badge <?php echo esc_attr( $cond_class ); ?>"><?php echo esc_html( $cond_label ); ?></span>

					<?php if ( '' !== $grade_note && 'new' !== $condition ) : ?>
						<div class="pdp-grade-note">
							<strong><?php esc_html_e( 'Condition note:', 'cove' ); ?></strong>
							<?php echo esc_html( $grade_note ); ?>
						</div>
					<?php endif; ?>

					<!-- Price -->
					<div class="pdp-price">
						<?php if ( $rrp > 0 && (float) $product->get_price() < $rrp ) : ?>
							<s class="pdp-price__rrp"><?php echo wp_kses_post( wc_price( $rrp ) ); ?></s>
						<?php endif; ?>
						<span class="pdp-price__current"><?php echo $product->get_price_html(); // phpcs:ignore ?></span>
						<?php if ( $saving > 0 ) : ?>
							<span class="saving-badge">
								<?php printf( esc_html__( 'Save R%s', 'cove' ), esc_html( number_format_i18n( $saving ) ) ); ?>
							</span>
						<?php endif; ?>
					</div>

					<!-- Warranty -->
					<?php if ( '' !== $warranty ) : ?>
						<p class="pdp-warranty">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
							<?php printf( esc_html__( 'Includes %s warranty', 'cove' ), esc_html( $warranty ) ); ?>
						</p>
					<?php endif; ?>

					<!-- Add to cart -->
					<div class="pdp-atc-bar">
						<?php if ( function_exists( 'woocommerce_template_single_add_to_cart' ) ) {
							woocommerce_template_single_add_to_cart();
						} ?>
					</div>

					<!-- Accordions -->
					<div class="pdp-accordions">

						<?php if ( $product->get_description() ) : ?>
							<div class="pdp-accordion">
								<details open>
									<summary><?php esc_html_e( 'Description', 'cove' ); ?></summary>
									<div class="pdp-accordion__body"><?php echo wp_kses_post( $product->get_description() ); ?></div>
								</details>
							</div>
						<?php endif; ?>

						<?php
						$specs = array_filter( array(
							__( 'Brand', 'cove' )         => $brand,
							__( 'Energy rating', 'cove' ) => $energy,
							__( 'Colour', 'cove' )        => $colour,
							__( 'Dimensions', 'cove' )    => $dims,
							__( 'Weight', 'cove' )        => $weight > 0 ? $weight . ' kg' : '',
							__( 'Condition', 'cove' )     => $cond_label,
						) );
						if ( ! empty( $specs ) ) : ?>
							<div class="pdp-accordion">
								<details>
									<summary><?php esc_html_e( 'Specifications', 'cove' ); ?></summary>
									<div class="pdp-accordion__body">
										<table class="spec-table">
											<?php foreach ( $specs as $label => $value ) : ?>
												<tr>
													<td><?php echo esc_html( $label ); ?></td>
													<td><?php echo esc_html( $value ); ?></td>
												</tr>
											<?php endforeach; ?>
										</table>
									</div>
								</details>
							</div>
						<?php endif; ?>

						<div class="pdp-accordion">
							<details>
								<summary><?php esc_html_e( 'Warranty & returns', 'cove' ); ?></summary>
								<div class="pdp-accordion__body">
									<?php if ( '' !== $warranty ) : ?>
										<p><?php printf( esc_html__( 'This product includes a %s warranty.', 'cove' ), esc_html( $warranty ) ); ?></p>
									<?php endif; ?>
									<p><?php esc_html_e( 'We offer 30-day hassle-free returns on all products. Items must be in the same condition as received.', 'cove' ); ?></p>
									<p><?php esc_html_e( 'For Grade B and C stock, cosmetic condition is as described - warranty covers functionality only.', 'cove' ); ?></p>
								</div>
							</details>
						</div>

					</div>
				</div>
			</div>

			<!-- Related products -->
			<?php
			$related_ids = wc_get_related_products( $pid, 4 );
			if ( ! empty( $related_ids ) ) :
				$related_products = array_filter( array_map( 'wc_get_product', $related_ids ) );
				?>
				<section class="section section--tight" data-reveal>
					<div class="section-head">
						<h2 class="t-2"><?php esc_html_e( 'You might also need', 'cove' ); ?></h2>
					</div>
					<ul class="products-grid">
						<?php
						$cove_card = get_theme_file_path( 'woocommerce/content-product.php' );
						foreach ( $related_products as $related ) :
							$GLOBALS['product'] = $related; // phpcs:ignore
							$product = $related;            // phpcs:ignore
							if ( file_exists( $cove_card ) ) { require $cove_card; }
						endforeach;
						wp_reset_postdata();
						?>
					</ul>
				</section>
			<?php endif; ?>

		</div>
	</main>

	<!-- Sticky buy bar (appears on scroll) -->
	<div class="pdp-sticky-bar" aria-hidden="true">
		<div class="pdp-sticky-bar__product">
			<span class="pdp-sticky-bar__name"><?php echo esc_html( $product->get_name() ); ?></span>
			<span class="pdp-sticky-bar__price"><?php echo $product->get_price_html(); // phpcs:ignore ?></span>
		</div>
		<?php if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
			woocommerce_template_loop_add_to_cart( array( 'class' => 'btn btn--primary' ) );
		} ?>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
