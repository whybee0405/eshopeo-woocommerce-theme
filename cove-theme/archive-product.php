<?php
/**
 * COVE product archive — catalogue with sidebar filters.
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();

$cove_shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );

// Read active filters from GET.
$active_condition = isset( $_GET['condition'] ) ? sanitize_text_field( wp_unslash( $_GET['condition'] ) ) : ''; // phpcs:ignore
$active_brand     = isset( $_GET['brand'] )     ? sanitize_text_field( wp_unslash( $_GET['brand'] ) )     : ''; // phpcs:ignore
$active_cat       = isset( $_GET['cat'] )       ? sanitize_text_field( wp_unslash( $_GET['cat'] ) )       : ''; // phpcs:ignore
$active_orderby   = isset( $_GET['orderby'] )   ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) )   : ''; // phpcs:ignore
$active_price_min = isset( $_GET['price_min'] ) ? intval( $_GET['price_min'] ) : 0; // phpcs:ignore
$active_price_max = isset( $_GET['price_max'] ) ? intval( $_GET['price_max'] ) : 20000; // phpcs:ignore

// Build active chips.
$chips = array();
if ( '' !== $active_condition ) { $chips[] = array( 'label' => function_exists( 'cove_condition_label' ) ? cove_condition_label( $active_condition ) : $active_condition, 'param' => 'condition' ); }
if ( '' !== $active_brand )     { $chips[] = array( 'label' => ucwords( str_replace( '-', ' ', $active_brand ) ), 'param' => 'brand' ); }
if ( '' !== $active_cat )       { $chips[] = array( 'label' => ucwords( str_replace( '-', ' ', $active_cat ) ),  'param' => 'cat' ); }

// Available brands from taxonomy.
$brands = get_terms( array( 'taxonomy' => 'product_brand', 'hide_empty' => true, 'number' => 30 ) );
$brands = is_wp_error( $brands ) ? array() : $brands;
?>

<main id="main">
	<div class="container section">

		<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) { woocommerce_breadcrumb(); } ?>

		<div class="catalogue-layout">

			<!-- Sidebar filters -->
			<aside class="filter-sidebar" aria-label="<?php esc_attr_e( 'Filter products', 'cove' ); ?>">
				<form method="get" action="<?php echo esc_url( $cove_shop ); ?>" data-filter-form>
					<div class="filter-sidebar__title">
						<span><?php esc_html_e( 'Filters', 'cove' ); ?></span>
						<?php if ( ! empty( $chips ) ) : ?>
							<a class="filter-clear-all" href="<?php echo esc_url( $cove_shop ); ?>"><?php esc_html_e( 'Clear all', 'cove' ); ?></a>
						<?php endif; ?>
					</div>

					<!-- Condition -->
					<div class="filter-group">
						<span class="filter-group__label"><?php esc_html_e( 'Condition', 'cove' ); ?></span>
						<div class="filter-options">
							<?php
							$conditions = array(
								'new'     => __( 'New', 'cove' ),
								'grade-a' => __( 'Grade A', 'cove' ),
								'grade-b' => __( 'Grade B', 'cove' ),
								'grade-c' => __( 'Grade C', 'cove' ),
							);
							foreach ( $conditions as $slug => $label ) :
								$grade_key = str_replace( '-', '', $slug );
								?>
								<label class="check-label filter-grade-<?php echo esc_attr( $grade_key ); ?>">
									<input type="checkbox" name="condition" value="<?php echo esc_attr( $slug ); ?>" <?php checked( $active_condition, $slug ); ?>>
									<?php echo esc_html( $label ); ?>
								</label>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Category -->
					<div class="filter-group">
						<span class="filter-group__label"><?php esc_html_e( 'Category', 'cove' ); ?></span>
						<div class="filter-options">
							<?php
							$filter_cats = function_exists( 'cove_categories' ) ? cove_categories() : array();
							foreach ( $filter_cats as $slug => $cat ) :
								?>
								<label class="check-label">
									<input type="checkbox" name="cat" value="<?php echo esc_attr( $slug ); ?>" <?php checked( $active_cat, $slug ); ?>>
									<?php echo esc_html( $cat['label'] ); ?>
								</label>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Price range -->
					<div class="filter-group">
						<span class="filter-group__label"><?php esc_html_e( 'Price range', 'cove' ); ?></span>
						<div class="range-wrap" data-price-range>
							<div class="range-track">
								<div class="range-fill"></div>
								<input type="range" class="range-thumb" data-min
									min="0" max="20000" step="500"
									value="<?php echo esc_attr( $active_price_min ); ?>">
								<input type="range" class="range-thumb" data-max
									min="0" max="20000" step="500"
									value="<?php echo esc_attr( $active_price_max ); ?>">
							</div>
							<div class="range-labels">
								<span data-label-min>R<?php echo esc_html( number_format_i18n( $active_price_min ) ); ?></span>
								<span data-label-max>R<?php echo esc_html( number_format_i18n( $active_price_max ) ); ?></span>
							</div>
						</div>
						<input type="hidden" name="price_min" value="<?php echo esc_attr( $active_price_min ); ?>">
						<input type="hidden" name="price_max" value="<?php echo esc_attr( $active_price_max ); ?>">
					</div>

					<!-- Brands -->
					<?php if ( ! empty( $brands ) ) : ?>
						<div class="filter-group">
							<span class="filter-group__label"><?php esc_html_e( 'Brand', 'cove' ); ?></span>
							<div class="filter-options">
								<?php foreach ( $brands as $brand_term ) : ?>
									<label class="check-label">
										<input type="checkbox" name="brand" value="<?php echo esc_attr( $brand_term->slug ); ?>" <?php checked( $active_brand, $brand_term->slug ); ?>>
										<?php echo esc_html( $brand_term->name ); ?>
									</label>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					<button type="submit" class="btn btn--primary btn--full" style="margin-top: var(--s-5);"><?php esc_html_e( 'Apply filters', 'cove' ); ?></button>
				</form>
			</aside>

			<!-- Product grid -->
			<div class="catalogue-main">

				<!-- Mobile filter toggle -->
				<button class="filter-toggle-btn btn btn--outline btn--sm" type="button" style="margin-bottom: var(--s-4);">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="12" y1="18" x2="20" y2="18"/></svg>
					<?php esc_html_e( 'Filters', 'cove' ); ?>
				</button>

				<!-- Catalogue header -->
				<div class="catalogue-header">
					<?php if ( function_exists( 'woocommerce_result_count' ) ) : ?>
						<p class="catalogue-count">
							<?php woocommerce_result_count(); ?>
						</p>
					<?php endif; ?>

					<div class="catalogue-sort">
						<select class="select" name="orderby" aria-label="<?php esc_attr_e( 'Sort products', 'cove' ); ?>">
							<option value=""    <?php selected( $active_orderby, '' ); ?>><?php esc_html_e( 'Newest', 'cove' ); ?></option>
							<option value="price" <?php selected( $active_orderby, 'price' ); ?>><?php esc_html_e( 'Price: low to high', 'cove' ); ?></option>
							<option value="price-desc" <?php selected( $active_orderby, 'price-desc' ); ?>><?php esc_html_e( 'Price: high to low', 'cove' ); ?></option>
							<option value="saving" <?php selected( $active_orderby, 'saving' ); ?>><?php esc_html_e( 'Biggest saving', 'cove' ); ?></option>
						</select>
					</div>
				</div>

				<!-- Active filter chips -->
				<?php if ( ! empty( $chips ) ) : ?>
					<div class="active-chips">
						<?php foreach ( $chips as $chip ) : ?>
							<span class="active-chip" data-param="<?php echo esc_attr( $chip['param'] ); ?>">
								<?php echo esc_html( $chip['label'] ); ?>
								<button class="active-chip__remove" type="button" aria-label="<?php printf( esc_attr__( 'Remove %s filter', 'cove' ), esc_attr( $chip['label'] ) ); ?>">&#215;</button>
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Products -->
				<?php if ( woocommerce_product_loop() ) : ?>
					<ul class="products-grid">
						<?php
						while ( have_posts() ) :
							the_post();
							$product = wc_get_product( get_the_ID() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
							$cove_card = get_theme_file_path( 'woocommerce/content-product.php' );
							if ( file_exists( $cove_card ) ) { require $cove_card; }
						endwhile;
						?>
					</ul>
					<?php woocommerce_pagination(); ?>
				<?php else : ?>
					<p class="t-lead" style="padding: var(--s-9) 0; text-align:center; color: var(--muted);">
						<?php esc_html_e( 'No products found matching your filters.', 'cove' ); ?>
						<a class="link-arrow" href="<?php echo esc_url( $cove_shop ); ?>" style="display:inline-flex; margin-top: var(--s-4);"><?php esc_html_e( 'Clear filters', 'cove' ); ?></a>
					</p>
				<?php endif; ?>

			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
