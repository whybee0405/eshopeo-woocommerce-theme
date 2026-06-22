<?php
/**
 * COVE product card loop template.
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;

global $product;
if ( ! is_a( $product, 'WC_Product' ) ) { return; }

$pid       = $product->get_id();
$permalink = get_permalink( $pid );
$title     = $product->get_name();
$brand     = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_brand' ) : '';
$condition = function_exists( 'cove_product_condition' ) ? cove_product_condition( $pid ) : 'new';
$cond_label= function_exists( 'cove_condition_label' ) ? cove_condition_label( $condition ) : 'New';
$cond_class= function_exists( 'cove_condition_class' ) ? cove_condition_class( $condition ) : 'badge-new';
$grade_note= function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_grade_notes' ) : '';
$saving    = function_exists( 'cove_saving' ) ? cove_saving( $pid ) : 0;
$rrp       = function_exists( 'cove_meta' ) ? (float) cove_meta( $pid, '_cove_rrp' ) : 0;
$has_sale  = $product->is_on_sale() || ( $rrp > 0 && (float) $product->get_price() < $rrp );
?>
<li class="product-card" data-product-id="<?php echo esc_attr( $pid ); ?>">

	<a class="product-card__media" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail( $pid ) ) {
			echo get_the_post_thumbnail( $pid, 'cove-card', array( 'loading' => 'lazy', 'alt' => esc_attr( $title ) ) ); // phpcs:ignore
		} else {
			echo '<img src="' . esc_url( get_theme_file_uri( 'images/hero/hero-room.svg' ) ) . '" alt="" aria-hidden="true" width="600" height="600" loading="lazy">';
		}
		?>

		<span class="product-card__badges">
			<span class="badge <?php echo esc_attr( $cond_class ); ?>"><?php echo esc_html( $cond_label ); ?></span>
		</span>

		<?php if ( $saving > 0 ) : ?>
			<span class="saving-badge product-card__saving-badge">
				<?php printf( esc_html__( 'Save R%s', 'cove' ), esc_html( number_format_i18n( $saving ) ) ); ?>
			</span>
		<?php endif; ?>
	</a>

	<div class="product-card__body">
		<?php if ( '' !== $brand ) : ?>
			<span class="product-card__brand"><?php echo esc_html( $brand ); ?></span>
		<?php endif; ?>

		<h2 class="product-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
		</h2>

		<?php if ( '' !== $grade_note && 'new' !== $condition ) : ?>
			<p class="product-card__grade-note"><?php echo esc_html( $grade_note ); ?></p>
		<?php endif; ?>

		<div class="product-card__price">
			<?php if ( $has_sale && $rrp > 0 ) : ?>
				<s class="product-card__rrp"><?php echo esc_html( wc_price( $rrp ) ); ?></s>
			<?php endif; ?>
			<span class="product-card__current"><?php echo $product->get_price_html(); // phpcs:ignore ?></span>
		</div>

		<?php
		if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
			echo '<div class="product-card__atc">';
			woocommerce_template_loop_add_to_cart( array( 'class' => 'btn btn--primary btn--full' ) );
			echo '</div>';
		}
		?>
	</div>
</li>
