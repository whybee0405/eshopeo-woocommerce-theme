<?php
/**
 * WooCommerce shop archive.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;
get_header();
$shop_title = woocommerce_page_title( false );
?>
<section class="section section--cream shop-hero">
	<div class="container">
		<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) { woocommerce_breadcrumb(); } ?>
		<p class="eyebrow"><?php esc_html_e( 'Future shop', 'kbap' ); ?></p>
		<h1 class="t-1"><?php echo esc_html( $shop_title ? $shop_title : __( 'K-BAP products', 'kbap' ) ); ?></h1>
		<p class="lead"><?php esc_html_e( 'Built for K-BAP Kimchi, meal kits, sauces, pantry staples, market drops and catering packs. Demo products show how the shop will scale.', 'kbap' ); ?></p>
	</div>
</section>

<section class="section shop-section">
	<div class="container">
		<div class="shop-toolbar">
			<div>
				<?php if ( function_exists( 'woocommerce_result_count' ) ) { woocommerce_result_count(); } ?>
			</div>
			<?php if ( function_exists( 'woocommerce_catalog_ordering' ) ) { woocommerce_catalog_ordering(); } ?>
		</div>

		<?php if ( woocommerce_product_loop() ) : ?>
			<ul class="products kbap-products">
				<?php
				while ( have_posts() ) :
					the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;
				?>
			</ul>
			<?php woocommerce_pagination(); ?>
		<?php else : ?>
			<div class="empty-shop">
				<h2 class="t-2"><?php esc_html_e( 'The pantry is being stocked.', 'kbap' ); ?></h2>
				<p><?php esc_html_e( 'Import the demo products or add K-BAP Kimchi, meal kits and catering packs in WooCommerce.', 'kbap' ); ?></p>
				<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/catering/' ) ); ?>"><?php esc_html_e( 'Ask about catering', 'kbap' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
