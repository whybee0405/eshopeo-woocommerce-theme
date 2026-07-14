<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
if ( ! $product instanceof WC_Product ) {
	return;
}

$product_id   = $product->get_id();
$category     = partsmall_primary_product_category( $product_id );
$makes        = partsmall_parse_csv( (string) partsmall_meta( $product_id, '_part_compatible_makes' ) );
$brand        = (string) partsmall_meta( $product_id, '_part_private_brand' );
$part_number  = (string) partsmall_meta( $product_id, '_part_number' );
$availability = (string) partsmall_meta( $product_id, '_part_availability' );
$badges       = partsmall_part_badges( $product );
?>
<li <?php wc_product_class( 'part-card', $product ); ?>>
	<a class="part-card__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php echo partsmall_product_image_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</a>
	<div class="part-card__body">
		<div class="part-card__meta">
			<?php foreach ( $badges as $badge ) : ?>
				<span class="badge badge--<?php echo esc_attr( $badge['tone'] ); ?>"><?php echo esc_html( $badge['label'] ); ?></span>
			<?php endforeach; ?>
		</div>
		<p class="part-card__category"><?php echo esc_html( $category ? $category->name : __( 'Part', 'parts-mall' ) ); ?></p>
		<h3 class="t-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( $part_number ) : ?>
			<p class="part-card__spec mono"><?php echo esc_html( $part_number ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $makes ) ) : ?>
			<p class="part-card__spec"><?php echo esc_html( implode( ', ', array_slice( $makes, 0, 3 ) ) ); ?></p>
		<?php endif; ?>
		<?php if ( $brand ) : ?>
			<span class="badge badge--paper"><?php echo esc_html( $brand ); ?></span>
		<?php endif; ?>
		<?php if ( '' !== $product->get_price() ) : ?>
			<div class="part-card__price"><?php echo wp_kses_post( wc_price( (float) $product->get_price() ) ); ?></div>
		<?php endif; ?>
		<p class="part-card__spec"><?php echo esc_html( ucfirst( str_replace( '_', ' ', $availability ) ) ); ?></p>
		<div class="part-card__actions">
			<button type="button" class="btn btn--signal btn--sm" data-enquiry-trigger data-enquiry-type="part" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-name="<?php echo esc_attr( $product->get_name() ); ?>"><?php esc_html_e( 'Enquire about this part', 'parts-mall' ); ?></button>
			<a class="btn btn--outline btn--sm" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Find a branch', 'parts-mall' ); ?></a>
		</div>
	</div>
</li>
