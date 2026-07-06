<?php
/**
 * Product card.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;
global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

$pid       = $product->get_id();
$permalink = get_permalink( $pid );
$title     = $product->get_name();
$family    = kbap_meta( $pid, '_kbap_menu_family', __( 'K-BAP', 'kbap' ) );
$heat      = kbap_meta( $pid, '_kbap_heat' );
$serves    = kbap_meta( $pid, '_kbap_serves' );
?>
<li class="product-card">
	<a class="product-card__media" href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
		<?php
		if ( has_post_thumbnail( $pid ) ) {
			echo get_the_post_thumbnail( $pid, 'kbap-card', array( 'loading' => 'lazy', 'alt' => esc_attr( $title ) ) );
		} else {
			echo '<img src="' . esc_url( get_theme_file_uri( 'images/kimchi-product.png' ) ) . '" alt="" loading="lazy">';
		}
		?>
	</a>
	<div class="product-card__body">
		<p class="eyebrow"><?php echo esc_html( $family ); ?></p>
		<h2 class="product-card__title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h2>
		<p class="product-card__desc"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 18 ) ); ?></p>
		<div class="dish-meta">
			<?php if ( $heat ) : ?><span><?php echo esc_html( $heat ); ?></span><?php endif; ?>
			<?php if ( $serves ) : ?><span><?php echo esc_html( $serves ); ?></span><?php endif; ?>
		</div>
		<div class="product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		<?php if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) : ?>
			<div class="product-card__atc"><?php woocommerce_template_loop_add_to_cart( array( 'class' => 'btn btn--primary btn--full' ) ); ?></div>
		<?php endif; ?>
	</div>
</li>
