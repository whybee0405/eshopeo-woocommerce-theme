<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'partsmall_filter_values' ) ) {
	function partsmall_filter_values( string $key ): array {
		if ( empty( $_GET[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return array();
		}
		$raw = wp_unslash( $_GET[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$raw = is_array( $raw ) ? $raw : array( $raw );
		return array_values( array_filter( array_map( 'sanitize_title', $raw ) ) );
	}
}

if ( ! function_exists( 'partsmall_shop_url' ) ) {
	function partsmall_shop_url(): string {
		return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/catalogue' );
	}
}

if ( ! function_exists( 'partsmall_render_catalogue_filters' ) ) {
	function partsmall_render_catalogue_filters( string $instance = 'sidebar' ): void {
		$groups         = partsmall_category_groups();
		$makes          = partsmall_makes();
		$brands         = partsmall_private_brands();
		$active_cats    = partsmall_filter_values( 'category' );
		$active_makes   = partsmall_filter_values( 'make' );
		$active_brands  = partsmall_filter_values( 'brand' );
		$active_stock   = partsmall_filter_values( 'availability' );
		$active_orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$prefix         = 'catalogue-' . sanitize_html_class( $instance ) . '-';
		?>
		<form method="get" action="<?php echo esc_url( partsmall_shop_url() ); ?>">
			<div class="filter-group">
				<h2 class="filter-group__title"><?php esc_html_e( 'Category', 'parts-mall' ); ?></h2>
				<ul class="check-list">
					<?php foreach ( $groups as $slug => $group ) : ?>
						<li>
							<label class="check-row" for="<?php echo esc_attr( $prefix . $slug ); ?>">
								<input id="<?php echo esc_attr( $prefix . $slug ); ?>" type="checkbox" name="category[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, $active_cats, true ) ); ?>>
								<span><?php echo esc_html( $group['label'] ); ?></span>
							</label>
							<ul>
								<?php foreach ( $group['children'] as $child_slug => $child_label ) : ?>
									<li>
										<label class="check-row" for="<?php echo esc_attr( $prefix . $child_slug ); ?>">
											<input id="<?php echo esc_attr( $prefix . $child_slug ); ?>" type="checkbox" name="category[]" value="<?php echo esc_attr( $child_slug ); ?>" <?php checked( in_array( $child_slug, $active_cats, true ) ); ?>>
											<span><?php echo esc_html( $child_label ); ?></span>
										</label>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="filter-group">
				<h2 class="filter-group__title"><?php esc_html_e( 'Vehicle make', 'parts-mall' ); ?></h2>
				<ul class="check-list">
					<?php foreach ( $makes as $slug => $label ) : ?>
						<li>
							<label class="check-row" for="<?php echo esc_attr( $prefix . 'make-' . $slug ); ?>">
								<input id="<?php echo esc_attr( $prefix . 'make-' . $slug ); ?>" type="checkbox" name="make[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, $active_makes, true ) ); ?>>
								<span><?php echo esc_html( $label ); ?></span>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="filter-group">
				<h2 class="filter-group__title"><?php esc_html_e( 'Private brand', 'parts-mall' ); ?></h2>
				<ul class="check-list">
					<?php foreach ( $brands as $slug => $brand ) : ?>
						<li>
							<label class="check-row" for="<?php echo esc_attr( $prefix . 'brand-' . $slug ); ?>">
								<input id="<?php echo esc_attr( $prefix . 'brand-' . $slug ); ?>" type="checkbox" name="brand[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, $active_brands, true ) ); ?>>
								<span><?php echo esc_html( $brand['label'] ); ?></span>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="filter-group">
				<h2 class="filter-group__title"><?php esc_html_e( 'Availability', 'parts-mall' ); ?></h2>
				<ul class="check-list">
					<li><label class="check-row"><input type="checkbox" name="availability[]" value="in_stock" <?php checked( in_array( 'in_stock', $active_stock, true ) ); ?>><span><?php esc_html_e( 'In stock', 'parts-mall' ); ?></span></label></li>
					<li><label class="check-row"><input type="checkbox" name="availability[]" value="order_in" <?php checked( in_array( 'order_in', $active_stock, true ) ); ?>><span><?php esc_html_e( 'Order in', 'parts-mall' ); ?></span></label></li>
					<li><label class="check-row"><input type="checkbox" name="availability[]" value="check_branch" <?php checked( in_array( 'check_branch', $active_stock, true ) ); ?>><span><?php esc_html_e( 'Check branch', 'parts-mall' ); ?></span></label></li>
				</ul>
			</div>

			<?php if ( '' !== $active_orderby ) : ?>
				<input type="hidden" name="orderby" value="<?php echo esc_attr( $active_orderby ); ?>">
			<?php endif; ?>

			<div class="filter-group">
				<button type="submit" class="btn btn--signal btn--block"><?php esc_html_e( 'Show results', 'parts-mall' ); ?></button>
				<a class="btn btn--outline btn--block" href="<?php echo esc_url( partsmall_shop_url() ); ?>" style="margin-top:.75rem;"><?php esc_html_e( 'Reset filters', 'parts-mall' ); ?></a>
			</div>
		</form>
		<?php
	}
}

get_header();

global $wp_query;
$found       = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
$current_obj = get_queried_object();
$title       = ( $current_obj instanceof WP_Term && ! empty( $current_obj->name ) ) ? $current_obj->name : __( 'Catalogue', 'parts-mall' );
?>

<div class="catalogue">
	<section class="section section--tight">
		<div class="container">
			<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
				<?php woocommerce_breadcrumb(); ?>
			<?php endif; ?>
			<header class="catalogue__hero">
				<p class="eyebrow"><?php esc_html_e( 'Parts catalogue', 'parts-mall' ); ?></p>
				<h1 class="t-1"><?php echo esc_html( $title ); ?></h1>
				<p class="lead"><?php esc_html_e( 'Browse the Parts-Mall catalogue by category, vehicle make, and private brand to identify the right part before speaking to a branch or the commercial team.', 'parts-mall' ); ?></p>
				<div class="cluster catalogue__hero-actions">
					<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Speak to a branch', 'parts-mall' ); ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Commercial enquiry', 'parts-mall' ); ?></a>
				</div>
			</header>
		</div>
	</section>

	<div class="container">
		<div class="catalogue__layout">
			<aside class="filters" aria-label="<?php esc_attr_e( 'Catalogue filters', 'parts-mall' ); ?>">
				<?php partsmall_render_catalogue_filters( 'sidebar' ); ?>
			</aside>

			<div>
				<div class="filter-toolbar">
					<p class="result-count"><?php printf( esc_html__( '%s results', 'parts-mall' ), esc_html( number_format_i18n( $found ) ) ); ?></p>
					<div class="cluster">
						<form method="get" action="<?php echo esc_url( partsmall_shop_url() ); ?>" class="cluster">
							<?php foreach ( array( 'category', 'make', 'brand', 'availability' ) as $carry ) : ?>
								<?php foreach ( partsmall_filter_values( $carry ) as $index => $value ) : ?>
									<input type="hidden" name="<?php echo esc_attr( $carry ); ?>[<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $value ); ?>">
								<?php endforeach; ?>
							<?php endforeach; ?>
							<label class="sr-only" for="catalogue-orderby"><?php esc_html_e( 'Sort parts', 'parts-mall' ); ?></label>
							<select id="catalogue-orderby" name="orderby" onchange="this.form.submit()">
								<option value=""><?php esc_html_e( 'Default sort', 'parts-mall' ); ?></option>
								<option value="title" <?php selected( isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : '', 'title' ); ?>><?php esc_html_e( 'Name A-Z', 'parts-mall' ); ?></option>
								<option value="title-desc" <?php selected( isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : '', 'title-desc' ); ?>><?php esc_html_e( 'Name Z-A', 'parts-mall' ); ?></option>
								<option value="newest" <?php selected( isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : '', 'newest' ); ?>><?php esc_html_e( 'Newest first', 'parts-mall' ); ?></option>
							</select>
						</form>
						<button type="button" class="btn btn--outline btn--sm filter-toggle" data-filter-open><?php esc_html_e( 'Filters', 'parts-mall' ); ?></button>
					</div>
				</div>

				<?php if ( function_exists( 'woocommerce_product_loop' ) ? woocommerce_product_loop() : have_posts() ) : ?>
					<ul class="products part-grid">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php if ( function_exists( 'wc_get_template_part' ) ) { wc_get_template_part( 'content', 'product' ); } ?>
						<?php endwhile; ?>
					</ul>
					<?php if ( function_exists( 'woocommerce_pagination' ) ) { woocommerce_pagination(); } ?>
				<?php else : ?>
					<div class="catalogue__empty">
						<p class="eyebrow"><?php esc_html_e( 'No parts matched this combination', 'parts-mall' ); ?></p>
						<h2 class="t-2"><?php esc_html_e( 'Broaden the filters or ask a branch to help you source the closest fit.', 'parts-mall' ); ?></h2>
						<p class="muted"><?php esc_html_e( 'Try a broader category, remove one filter, or contact a branch directly if you only have the OEM reference or a partial part number.', 'parts-mall' ); ?></p>
						<div class="cluster">
							<a class="btn btn--outline" href="<?php echo esc_url( partsmall_shop_url() ); ?>"><?php esc_html_e( 'Reset filters', 'parts-mall' ); ?></a>
							<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Find a branch', 'parts-mall' ); ?></a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="filter-scrim" data-filter-scrim></div>
<aside class="filter-drawer" data-filter-drawer aria-label="<?php esc_attr_e( 'Catalogue filters', 'parts-mall' ); ?>">
	<div class="filter-drawer__head">
		<h2 class="t-3"><?php esc_html_e( 'Filters', 'parts-mall' ); ?></h2>
		<button type="button" class="icon-btn" data-filter-close aria-label="<?php esc_attr_e( 'Close filters', 'parts-mall' ); ?>">&times;</button>
	</div>
	<?php partsmall_render_catalogue_filters( 'drawer' ); ?>
</aside>

<?php get_footer(); ?>
