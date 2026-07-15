<?php
/**
 * COVE homepage.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();

$cove_shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );
$cove_cats = function_exists( 'cove_categories' ) ? cove_categories() : array();
$brand_uri = get_theme_file_uri( 'images/brand/' );

$cove_new = array();
if ( function_exists( 'wc_get_products' ) ) {
	$cove_new = wc_get_products( array(
		'status'  => 'publish',
		'limit'   => 8,
		'orderby' => 'date',
		'order'   => 'DESC',
	) );
}

$cove_deals = array();
if ( function_exists( 'wc_get_products' ) ) {
	$deal_ids = get_posts( array(
		'post_type'   => 'product',
		'post_status' => 'publish',
		'numberposts' => 4,
		'tax_query'   => array( array( // phpcs:ignore WordPress.DB.SlowDBQuery
			'taxonomy' => 'product_condition',
			'field'    => 'slug',
			'terms'    => array( 'grade-a', 'grade-b' ),
		) ),
		'fields'      => 'ids',
	) );
	foreach ( $deal_ids as $did ) {
		$p = wc_get_product( $did );
		if ( $p ) {
			$cove_deals[] = $p;
		}
	}
}
?>

<main id="main">
	<section class="cove-clarity-hero cove-confidence-hero cove-confidence-hero--full-bleed" data-confidence-hero data-clarity-hero>
		<div class="container cove-clarity-hero__grid">
			<div class="cove-clarity-hero__copy confidence-reveal__copy-panel" data-hero-copy-panel data-reveal>
				<p class="cove-kicker"><?php esc_html_e( 'Appliances made clear', 'cove' ); ?></p>
				<h1 class="cove-clarity-hero__title"><?php esc_html_e( 'Premium appliances, clearly graded.', 'cove' ); ?></h1>
				<p class="cove-clarity-hero__lead"><?php esc_html_e( 'Inspected demo and graded appliances, priced around their real condition.', 'cove' ); ?></p>
				<div class="confidence-proof-list" aria-label="<?php esc_attr_e( 'COVE confidence proof points', 'cove' ); ?>">
					<span><?php esc_html_e( 'Cosmetic marks disclosed', 'cove' ); ?></span>
					<span><?php esc_html_e( 'Performance tested', 'cove' ); ?></span>
					<span><?php esc_html_e( 'Warranty included', 'cove' ); ?></span>
				</div>
				<div class="cove-clarity-hero__actions">
					<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $cove_shop ); ?>"><?php esc_html_e( 'Shop Better-Value Appliances', 'cove' ); ?></a>
					<a class="btn btn--glass btn--lg" href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'See Grade Examples', 'cove' ); ?></a>
				</div>
			</div>

			<div class="cove-clarity-hero__visual confidence-reveal" data-confidence-stage data-reveal>
				<img src="<?php echo esc_url( $brand_uri . 'cove-hero-showroom-photo.png' ); ?>" alt="<?php esc_attr_e( 'Premium kitchen and laundry appliance setting with a stainless fridge and washing machine.', 'cove' ); ?>" width="1536" height="1024" fetchpriority="high">
				<div class="clarity-lens confidence-reveal__lens" data-lens aria-hidden="true">
					<span><?php esc_html_e( 'Inspection lens', 'cove' ); ?></span>
				</div>

				<div class="confidence-reveal__price-card" data-price-card aria-live="polite">
					<p><?php esc_html_e( 'A Grade demo example', 'cove' ); ?></p>
					<div class="confidence-reveal__price-row">
						<s data-retail-price><?php esc_html_e( 'Retail R18,999', 'cove' ); ?></s>
						<strong data-cove-price><?php esc_html_e( 'COVE R14,799', 'cove' ); ?></strong>
					</div>
					<span data-saving-note><?php esc_html_e( 'Save R4,200 because the condition is clear.', 'cove' ); ?></span>
				</div>

				<button class="confidence-reveal__hotspot confidence-reveal__hotspot--scuff is-active is-invite" type="button" data-hotspot data-note="Cosmetic mark disclosed" data-impact="No performance impact. Priced into the saving." aria-label="<?php esc_attr_e( 'Reveal cosmetic mark inspection note', 'cove' ); ?>">
					<span><?php esc_html_e( 'Cosmetic mark disclosed', 'cove' ); ?></span>
				</button>
				<button class="confidence-reveal__hotspot confidence-reveal__hotspot--tested" type="button" data-hotspot data-note="Performance tested" data-impact="Cooling, controls and seals verified." aria-label="<?php esc_attr_e( 'Reveal performance tested inspection note', 'cove' ); ?>">
					<span><?php esc_html_e( 'Performance tested', 'cove' ); ?></span>
				</button>
				<button class="confidence-reveal__hotspot confidence-reveal__hotspot--saving" type="button" data-hotspot data-note="Why it costs less" data-impact="Demo handling mark, fully functional." aria-label="<?php esc_attr_e( 'Reveal saving reason inspection note', 'cove' ); ?>">
					<span><?php esc_html_e( 'Why it costs less', 'cove' ); ?></span>
				</button>
				<button class="confidence-reveal__hotspot confidence-reveal__hotspot--warranty" type="button" data-hotspot data-note="Warranty included" data-impact="Coverage shown clearly before checkout." aria-label="<?php esc_attr_e( 'Reveal warranty inspection note', 'cove' ); ?>">
					<span><?php esc_html_e( 'Warranty included', 'cove' ); ?></span>
				</button>
				<button class="confidence-reveal__hotspot confidence-reveal__hotspot--delivery" type="button" data-hotspot data-note="Delivery ready" data-impact="Large appliance delivery can be arranged." aria-label="<?php esc_attr_e( 'Reveal delivery inspection note', 'cove' ); ?>">
					<span><?php esc_html_e( 'Delivery ready', 'cove' ); ?></span>
				</button>
				<button class="confidence-reveal__hotspot confidence-reveal__hotspot--grade" type="button" data-hotspot data-note="A Grade example" data-impact="Near-new condition with transparent notes." aria-label="<?php esc_attr_e( 'Reveal A Grade inspection note', 'cove' ); ?>">
					<span><?php esc_html_e( 'A Grade example', 'cove' ); ?></span>
				</button>

				<div class="confidence-reveal__note" data-confidence-note>
					<strong><?php esc_html_e( 'Cosmetic mark disclosed', 'cove' ); ?></strong>
					<span><?php esc_html_e( 'No performance impact. Priced into the saving.', 'cove' ); ?></span>
				</div>

				<div class="confidence-reveal__grades" role="group" aria-label="<?php esc_attr_e( 'Compare appliance grades', 'cove' ); ?>">
					<button type="button" data-grade-option="new" data-retail="Retail R18,999" data-price="COVE R18,999" data-saving="Factory sealed, standard price." aria-pressed="false"><?php esc_html_e( 'New', 'cove' ); ?></button>
					<button class="is-active" type="button" data-grade-option="a" data-retail="Retail R18,999" data-price="COVE R14,799" data-saving="Save R4,200 because the condition is clear." aria-pressed="true"><?php esc_html_e( 'A Grade', 'cove' ); ?></button>
					<button type="button" data-grade-option="b" data-retail="Retail R18,999" data-price="COVE R12,999" data-saving="Light visible marks, tested functional." aria-pressed="false"><?php esc_html_e( 'B Grade', 'cove' ); ?></button>
					<button type="button" data-grade-option="c" data-retail="Retail R18,999" data-price="COVE R10,999" data-saving="Visible wear, strongest saving." aria-pressed="false"><?php esc_html_e( 'C Grade', 'cove' ); ?></button>
				</div>

				<div class="confidence-reveal__mobile-facts" aria-label="<?php esc_attr_e( 'COVE inspection facts', 'cove' ); ?>">
					<span><?php esc_html_e( 'Cosmetic mark disclosed', 'cove' ); ?></span>
					<span><?php esc_html_e( 'Performance tested', 'cove' ); ?></span>
					<span><?php esc_html_e( 'Why it costs less', 'cove' ); ?></span>
					<span><?php esc_html_e( 'Warranty included', 'cove' ); ?></span>
					<span><?php esc_html_e( 'Delivery ready', 'cove' ); ?></span>
					<span><?php esc_html_e( 'A Grade example', 'cove' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $cove_deals ) ) : ?>
		<section class="section cove-product-section cove-product-section--blue" data-reveal>
			<div class="container">
				<div class="section-head section-head--stacked">
					<p class="cove-kicker"><?php esc_html_e( 'Best value drops', 'cove' ); ?></p>
					<h2 class="t-1"><?php esc_html_e( 'Demo and graded appliances where the condition is already priced in.', 'cove' ); ?></h2>
					<a class="link-arrow" href="<?php echo esc_url( add_query_arg( 'orderby', 'saving', $cove_shop ) ); ?>"><?php esc_html_e( 'Browse better priced stock', 'cove' ); ?></a>
				</div>
				<ul class="products-grid products-grid--3">
					<?php
					$cove_card = get_theme_file_path( 'woocommerce/content-product.php' );
					foreach ( $cove_deals as $cove_p ) :
						$GLOBALS['product'] = $cove_p; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
						$product            = $cove_p; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
						if ( file_exists( $cove_card ) ) {
							require $cove_card;
						}
					endforeach;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<section class="cove-trust-ribbon" data-reveal>
		<div class="container cove-trust-ribbon__grid">
			<span><?php esc_html_e( 'LG', 'cove' ); ?></span>
			<span><?php esc_html_e( 'Samsung', 'cove' ); ?></span>
			<span><?php esc_html_e( 'Hisense', 'cove' ); ?></span>
			<span><?php esc_html_e( 'Bosch', 'cove' ); ?></span>
			<span><?php esc_html_e( 'Defy', 'cove' ); ?></span>
			<span><?php esc_html_e( 'Tested and verified', 'cove' ); ?></span>
		</div>
	</section>

	<section class="cove-home-search" data-reveal aria-labelledby="cove-home-search-title">
		<div class="container cove-home-search__inner">
			<div class="cove-home-search__copy">
				<p class="cove-kicker"><?php esc_html_e( 'Find your appliance', 'cove' ); ?></p>
				<h2 id="cove-home-search-title"><?php esc_html_e( 'Search by brand, model, category or grade.', 'cove' ); ?></h2>
			</div>
			<form role="search" method="get" class="cove-home-search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="sr-only" for="cove-home-search-input"><?php esc_html_e( 'Search appliances', 'cove' ); ?></label>
				<input id="cove-home-search-input" type="search" name="s" placeholder="<?php esc_attr_e( 'Try A Grade fridge, Bosch dishwasher, 8kg washer...', 'cove' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off">
				<input type="hidden" name="post_type" value="product">
				<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Search Stock', 'cove' ); ?></button>
			</form>
		</div>
	</section>

	<section class="cove-category-showroom section" data-reveal>
		<div class="container cove-split cove-split--category">
			<div class="cove-showroom-media">
				<img src="<?php echo esc_url( $brand_uri . 'cove-category-showroom-photo.png' ); ?>" alt="<?php esc_attr_e( 'Premium showroom displaying kitchen, laundry, climate and living appliances.', 'cove' ); ?>" width="1536" height="1024" loading="lazy">
			</div>
			<div class="cove-showroom-content">
				<p class="cove-kicker"><?php esc_html_e( 'Shop by category', 'cove' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Find the appliance by the room it improves.', 'cove' ); ?></h2>
				<div class="category-strip category-strip--premium">
					<?php foreach ( $cove_cats as $slug => $cat ) :
						$cat_url = add_query_arg( 'cat', $slug, $cove_shop );
						$term    = get_term_by( 'slug', $slug, 'product_cat' );
						$count   = $term ? (int) $term->count : 0;
						?>
						<a class="category-tile" href="<?php echo esc_url( $cat_url ); ?>">
							<img class="category-tile__icon" src="<?php echo esc_url( $cat['icon'] ); ?>" alt="" aria-hidden="true" width="48" height="48" loading="lazy">
							<span class="category-tile__label"><?php echo esc_html( $cat['label'] ); ?></span>
							<span class="category-tile__count">
								<?php echo $count > 0 ? esc_html( sprintf( _n( '%d product', '%d products', $count, 'cove' ), $count ) ) : esc_html__( 'Browse stock', 'cove' ); ?>
							</span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<section class="cove-grade-system section" data-reveal>
		<div class="container cove-split cove-split--grade">
			<div class="cove-grade-copy">
				<p class="cove-kicker"><?php esc_html_e( 'Choose your comfort level', 'cove' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Pick the grade that fits the room, budget and tolerance for cosmetic marks.', 'cove' ); ?></h2>
				<p class="t-lead"><?php esc_html_e( 'New, A, B and C are presented as a professional condition system, with inspection notes and warranty context on every relevant product.', 'cove' ); ?></p>
				<div class="grade-list">
					<?php
					$grades = array(
						array( 'key' => 'new', 'label' => __( 'New', 'cove' ), 'desc' => __( 'Factory sealed, full-price confidence.', 'cove' ) ),
						array( 'key' => 'a', 'label' => __( 'A Grade', 'cove' ), 'desc' => __( 'Near-new condition, often the strongest balance.', 'cove' ) ),
						array( 'key' => 'b', 'label' => __( 'B Grade', 'cove' ), 'desc' => __( 'Light visible marks, fully functional, sharper saving.', 'cove' ) ),
						array( 'key' => 'c', 'label' => __( 'C Grade', 'cove' ), 'desc' => __( 'Visible wear, tested and functional, utility-room value.', 'cove' ) ),
					);
					foreach ( $grades as $grade ) :
						?>
						<a class="grade-row grade-row--<?php echo esc_attr( $grade['key'] ); ?>" href="<?php echo esc_url( add_query_arg( 'condition', 'new' === $grade['key'] ? 'new' : 'grade-' . $grade['key'], $cove_shop ) ); ?>">
							<strong><?php echo esc_html( $grade['label'] ); ?></strong>
							<span><?php echo esc_html( $grade['desc'] ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="cove-grade-media">
				<img src="<?php echo esc_url( $brand_uri . 'cove-grade-inspection-photo.png' ); ?>" alt="<?php esc_attr_e( 'Close-up appliance inspection with white gloves, checklist and precision tools.', 'cove' ); ?>" width="1536" height="1024" loading="lazy">
			</div>
		</div>
	</section>

	<?php if ( ! empty( $cove_new ) ) : ?>
		<section class="section cove-product-section" data-reveal>
			<div class="container">
				<div class="section-head section-head--stacked">
					<p class="cove-kicker"><?php esc_html_e( 'Latest inspected stock', 'cove' ); ?></p>
					<h2 class="t-1"><?php esc_html_e( 'Fresh arrivals once you know how to read the value.', 'cove' ); ?></h2>
					<a class="link-arrow" href="<?php echo esc_url( add_query_arg( 'orderby', 'date', $cove_shop ) ); ?>"><?php esc_html_e( 'See all new stock', 'cove' ); ?></a>
				</div>
				<ul class="products-grid">
					<?php
					$cove_card = isset( $cove_card ) ? $cove_card : get_theme_file_path( 'woocommerce/content-product.php' );
					foreach ( $cove_new as $cove_p ) :
						$GLOBALS['product'] = $cove_p; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
						$product            = $cove_p; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
						if ( file_exists( $cove_card ) ) {
							require $cove_card;
						}
					endforeach;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<section class="section cove-aftercare" data-reveal>
		<div class="container cove-aftercare__inner">
			<div class="cove-aftercare__copy">
				<p class="cove-kicker"><?php esc_html_e( 'What happens after checkout?', 'cove' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'The appliance arrives with the same clarity you bought it with.', 'cove' ); ?></h2>
			</div>
			<div class="cove-aftercare__grid" aria-label="<?php esc_attr_e( 'After checkout reassurance', 'cove' ); ?>">
				<span><?php esc_html_e( 'Delivery arranged', 'cove' ); ?></span>
				<span><?php esc_html_e( 'Warranty path clear', 'cove' ); ?></span>
				<span><?php esc_html_e( 'Inspection record kept', 'cove' ); ?></span>
				<span><?php esc_html_e( 'Human support if anything feels off', 'cove' ); ?></span>
			</div>
		</div>
	</section>

	<section class="home-closing cove-closing" data-reveal>
		<div class="container cove-closing__inner">
			<p class="cove-kicker"><?php esc_html_e( 'Ready to upgrade your home?', 'cove' ); ?></p>
			<h2 class="t-hero"><?php esc_html_e( 'Premium appliances, without the showroom guesswork.', 'cove' ); ?></h2>
			<p class="t-lead"><?php esc_html_e( 'Browse trusted brands with clear grades, transparent specs, and simple delivery from COVE.', 'cove' ); ?></p>
			<div class="cluster" style="justify-content:center;">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $cove_shop ); ?>"><?php esc_html_e( 'Shop Appliances', 'cove' ); ?></a>
				<a class="btn btn--glass btn--lg" href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Understand Grades', 'cove' ); ?></a>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
