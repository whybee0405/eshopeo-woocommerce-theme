<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $product;
if ( ! $product instanceof WC_Product ) {
	$product = wc_get_product( get_the_ID() );
}

if ( ! $product instanceof WC_Product ) {
	?>
	<div class="container section">
		<p class="lead"><?php esc_html_e( 'This part could not be found.', 'parts-mall' ); ?></p>
	</div>
	<?php
	get_footer();
	return;
}

$product_id     = $product->get_id();
$category       = partsmall_primary_product_category( $product_id );
$makes          = partsmall_parse_csv( (string) partsmall_meta( $product_id, '_part_compatible_makes' ) );
$models         = (string) partsmall_meta( $product_id, '_part_compatible_models' );
$brand_label    = (string) partsmall_meta( $product_id, '_part_private_brand' );
$brand_slug     = sanitize_title( $brand_label );
$brand_map      = partsmall_private_brands();
$part_number    = (string) partsmall_meta( $product_id, '_part_number' );
$oem_reference  = (string) partsmall_meta( $product_id, '_part_oem_reference' );
$warranty       = (string) partsmall_meta( $product_id, '_part_warranty' );
$availability   = (string) partsmall_meta( $product_id, '_part_availability' );
$availability_map = array(
	'in_stock'     => __( 'In stock', 'parts-mall' ),
	'order_in'     => __( 'Order in', 'parts-mall' ),
	'check_branch' => __( 'Check branch availability', 'parts-mall' ),
);
$specs = array(
	__( 'Part number', 'parts-mall' )      => $part_number,
	__( 'OEM reference', 'parts-mall' )    => $oem_reference,
	__( 'Compatible makes', 'parts-mall' ) => ! empty( $makes ) ? implode( ', ', $makes ) : '',
	__( 'Compatible models', 'parts-mall' ) => $models,
	__( 'Private brand', 'parts-mall' )    => $brand_label,
	__( 'Warranty', 'parts-mall' )         => $warranty,
	__( 'Availability', 'parts-mall' )     => isset( $availability_map[ $availability ] ) ? $availability_map[ $availability ] : '',
);
$description = $product->get_short_description() ? $product->get_short_description() : $product->get_description();

$related_args = array(
	'status'  => 'publish',
	'limit'   => 4,
	'exclude' => array( $product_id ),
);
if ( $category instanceof WP_Term ) {
	$related_args['category'] = array( $category->slug );
}
$related_products = wc_get_products( $related_args );
?>

<div class="single-part__topbar">
	<div class="container">
		<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
			<?php woocommerce_breadcrumb(); ?>
		<?php endif; ?>
	</div>
</div>

<section class="section section--tight">
	<div class="container single-part__layout">
		<div class="single-gallery" data-reveal>
			<div class="single-gallery__main">
				<?php echo partsmall_product_image_html( $product, 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<ul class="single-gallery__thumbs">
				<?php for ( $i = 0; $i < 4; $i++ ) : ?>
					<li><?php echo partsmall_product_image_html( $product, 'thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
				<?php endfor; ?>
			</ul>
		</div>

		<div class="single-panel" data-reveal>
			<p class="eyebrow"><?php echo esc_html( $category ? $category->name : __( 'Part detail', 'parts-mall' ) ); ?></p>
			<h1 class="t-1"><?php echo esc_html( $product->get_name() ); ?></h1>

			<div class="single-panel__brand">
				<?php if ( isset( $brand_map[ $brand_slug ] ) ) : ?>
					<img src="<?php echo esc_url( $brand_map[ $brand_slug ]['logo'] ); ?>" alt="<?php echo esc_attr( $brand_label ); ?>" style="height:24px;width:auto;">
				<?php endif; ?>
				<span class="badge badge--signal"><?php echo esc_html( $brand_label ? $brand_label : __( 'Parts-Mall supply line', 'parts-mall' ) ); ?></span>
				<?php if ( $warranty ) : ?>
					<span class="badge badge--navy"><?php esc_html_e( 'Warranty supported', 'parts-mall' ); ?></span>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $makes ) ) : ?>
				<div class="cluster">
					<?php foreach ( $makes as $make ) : ?>
						<span class="badge badge--paper"><?php echo esc_html( $make ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<dl class="single-panel__meta">
				<?php foreach ( $specs as $label => $value ) : ?>
					<?php if ( '' === trim( (string) $value ) ) { continue; } ?>
					<div class="single-panel__meta-row">
						<dt><?php echo esc_html( $label ); ?></dt>
						<dd><?php echo esc_html( $value ); ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>

			<div class="single-panel__cta">
				<button type="button" class="btn btn--signal" data-enquiry-trigger data-enquiry-type="part" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-name="<?php echo esc_attr( $product->get_name() ); ?>"><?php esc_html_e( 'Enquire about this part', 'parts-mall' ); ?></button>
				<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Find the nearest branch for this part', 'parts-mall' ); ?></a>
				<button type="button" class="btn btn--outline" data-enquiry-trigger data-enquiry-type="bulk" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-name="<?php echo esc_attr( $product->get_name() ); ?>"><?php esc_html_e( 'Ask about bulk / trade pricing', 'parts-mall' ); ?></button>
			</div>

			<ul class="single-panel__assurance">
				<li><?php esc_html_e( 'Use this page to confirm the correct part before speaking to a branch or Parts-Mall consultant.', 'parts-mall' ); ?></li>
				<li><?php esc_html_e( 'Part numbers and OEM references help workshops and trade buyers order with confidence.', 'parts-mall' ); ?></li>
				<li><?php esc_html_e( 'Private-brand lines are supported by warranty and dependable supply positioning.', 'parts-mall' ); ?></li>
				<li><?php esc_html_e( 'Availability is handled through the branch network so you can get the right support faster.', 'parts-mall' ); ?></li>
			</ul>
		</div>
	</div>
</section>

<section class="section section--tight">
	<div class="container">
		<div class="spec-sheet" data-reveal>
			<?php foreach ( $specs as $label => $value ) : ?>
				<?php if ( '' === trim( (string) $value ) ) { continue; } ?>
				<div class="spec-sheet__item">
					<span class="spec-sheet__label"><?php echo esc_html( $label ); ?></span>
					<span class="spec-sheet__value"><?php echo esc_html( $value ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tight">
	<div class="container details-stack">
		<details class="accordion-card" open data-reveal>
			<summary><?php esc_html_e( 'Overview', 'parts-mall' ); ?></summary>
			<div class="accordion-card__content">
				<?php echo wpautop( wp_kses_post( $description ) ); ?>
			</div>
		</details>
		<details class="accordion-card" data-reveal>
			<summary><?php esc_html_e( 'Compatibility', 'parts-mall' ); ?></summary>
			<div class="accordion-card__content">
				<p><?php echo esc_html( ! empty( $makes ) ? implode( ', ', $makes ) : __( 'Compatibility confirmed on enquiry.', 'parts-mall' ) ); ?></p>
				<?php if ( $models ) : ?>
					<p><?php echo esc_html( $models ); ?></p>
				<?php endif; ?>
			</div>
		</details>
		<details class="accordion-card" data-reveal>
			<summary><?php esc_html_e( 'Warranty & quality', 'parts-mall' ); ?></summary>
			<div class="accordion-card__content">
				<p><?php echo esc_html( $warranty ? $warranty : __( 'Warranty details are confirmed by the supplying branch or trade contact.', 'parts-mall' ) ); ?></p>
				<p><?php esc_html_e( 'Parts-Mall balances trusted private-brand supply with OEM or genuine options where the right application calls for them.', 'parts-mall' ); ?></p>
			</div>
		</details>
	</div>
</section>

<?php if ( ! empty( $related_products ) ) : ?>
	<section class="section section--tight">
		<div class="container">
			<div class="stack" data-reveal>
				<p class="eyebrow"><?php esc_html_e( 'You may also need', 'parts-mall' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Related parts in this category', 'parts-mall' ); ?></h2>
			</div>
			<ul class="products part-grid" style="margin-top:1.5rem;">
				<?php
				global $post;
				foreach ( $related_products as $related_product ) :
					$product = $related_product;
					wc_get_template_part( 'content', 'product' );
				endforeach;
				wp_reset_postdata();
				?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>
