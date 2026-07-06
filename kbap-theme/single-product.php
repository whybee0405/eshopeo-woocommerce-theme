<?php
/**
 * Single WooCommerce product.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	global $product;
	if ( ! $product ) {
		$product = wc_get_product( get_the_ID() );
	}
	$pid     = $product ? $product->get_id() : get_the_ID();
	$serves  = kbap_meta( $pid, '_kbap_serves' );
	$heat    = kbap_meta( $pid, '_kbap_heat' );
	$storage = kbap_meta( $pid, '_kbap_storage' );
	$prep    = kbap_meta( $pid, '_kbap_prep' );
	$dietary = kbap_meta( $pid, '_kbap_dietary' );
	?>
	<section class="section product-detail">
		<div class="container product-detail__grid">
			<div class="product-gallery reveal">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'kbap-hero', array( 'alt' => esc_attr( get_the_title() ) ) );
				} else {
					echo '<img src="' . esc_url( get_theme_file_uri( 'images/kimchi-product.png' ) ) . '" alt="">';
				}
				?>
			</div>
			<div class="product-summary reveal">
				<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) { woocommerce_breadcrumb(); } ?>
				<p class="eyebrow"><?php echo esc_html( kbap_meta( $pid, '_kbap_menu_family', __( 'K-BAP product', 'kbap' ) ) ); ?></p>
				<h1 class="t-1"><?php the_title(); ?></h1>
				<?php if ( $product ) : ?>
					<div class="product-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				<?php endif; ?>
				<div class="lead"><?php woocommerce_template_single_excerpt(); ?></div>

				<div class="product-specs">
					<?php foreach ( array( __( 'Serves', 'kbap' ) => $serves, __( 'Heat', 'kbap' ) => $heat, __( 'Storage', 'kbap' ) => $storage, __( 'Prep', 'kbap' ) => $prep, __( 'Dietary', 'kbap' ) => $dietary ) as $label => $value ) : ?>
						<?php if ( '' !== $value ) : ?>
							<div><span><?php echo esc_html( $label ); ?></span><strong><?php echo esc_html( $value ); ?></strong></div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<?php if ( $product && function_exists( 'woocommerce_template_single_add_to_cart' ) ) : ?>
					<div class="product-buy"><?php woocommerce_template_single_add_to_cart(); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="section section--cream">
		<div class="container">
			<div class="section-head">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Details', 'kbap' ); ?></p>
					<h2 class="t-1"><?php esc_html_e( 'What to know before serving.', 'kbap' ); ?></h2>
				</div>
			</div>
			<div class="faq-list">
				<details class="faq-item" open>
					<summary><?php esc_html_e( 'Description', 'kbap' ); ?></summary>
					<div class="faq-body"><?php the_content(); ?></div>
				</details>
				<details class="faq-item">
					<summary><?php esc_html_e( 'Serving notes', 'kbap' ); ?></summary>
					<div class="faq-body"><?php echo esc_html( $serves ? sprintf( __( 'Designed to serve %s. For catering quantities, request a custom quote.', 'kbap' ), $serves ) : __( 'Serving sizes can be adjusted for catering and market orders.', 'kbap' ) ); ?></div>
				</details>
			</div>
		</div>
	</section>
	<?php
endwhile;
get_footer();
