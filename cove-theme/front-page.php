<?php
/**
 * COVE homepage — section order is the customer journey:
 * hero → categories → new arrivals → grade strip → deals →
 * trust bar → reviews → blog → closing CTA.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();

$cove_shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );
$cove_cats = function_exists( 'cove_categories' ) ? cove_categories() : array();
?>

<main id="main">

	<!-- 1. Hero — Three.js Room Environment -->
	<section class="home-hero" aria-label="<?php esc_attr_e( 'Homepage hero', 'cove' ); ?>">
		<canvas class="home-hero__canvas" id="cove-hero-canvas" aria-hidden="true"></canvas>
		<img class="home-hero__fallback"
			src="<?php echo esc_url( get_theme_file_uri( 'images/hero/hero-room.svg' ) ); ?>"
			alt="<?php esc_attr_e( 'Modern home interior with COVE appliances', 'cove' ); ?>"
			width="1200" height="600">

		<!-- Tooltip card (positioned by JS) -->
		<div class="hero-tooltip" id="cove-hero-tooltip" role="tooltip" aria-live="polite">
			<span class="hero-tooltip__badge badge"></span>
			<span class="hero-tooltip__name"></span>
			<span class="hero-tooltip__price"></span>
			<a class="hero-tooltip__link" href="#"><?php esc_html_e( 'Shop now', 'cove' ); ?></a>
		</div>

		<div class="container">
			<div class="home-hero__content">
				<p class="eyebrow eyebrow--amber home-hero__eyebrow"><?php esc_html_e( 'New & certified demo stock', 'cove' ); ?></p>
				<h1 class="home-hero__title">
					<?php esc_html_e( 'Every room.', 'cove' ); ?><br>
					<?php esc_html_e( 'Every budget.', 'cove' ); ?>
				</h1>
				<p class="home-hero__lead"><?php esc_html_e( 'Premium appliances, honest prices. Shop new stock or save up to 40% on Grade A, B and C demo units — every one tested and described honestly.', 'cove' ); ?></p>
				<div class="home-hero__cta cluster">
					<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $cove_shop ); ?>"><?php esc_html_e( 'Shop all products', 'cove' ); ?></a>
					<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Explore Grade deals', 'cove' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- 2. Shop by category -->
	<section class="section section--tight surface-white" data-reveal>
		<div class="container">
			<div class="section-head">
				<div class="stack-sm">
					<p class="eyebrow"><?php esc_html_e( 'Shop by room', 'cove' ); ?></p>
					<h2 class="t-2"><?php esc_html_e( 'What are you looking for?', 'cove' ); ?></h2>
				</div>
				<a class="link-arrow" href="<?php echo esc_url( $cove_shop ); ?>"><?php esc_html_e( 'All products', 'cove' ); ?></a>
			</div>
			<div class="category-grid">
				<?php foreach ( $cove_cats as $slug => $cat ) :
					$cat_url = add_query_arg( 'cat', $slug, $cove_shop );
					$count   = 0;
					if ( function_exists( 'wc_get_products' ) ) {
						$term = get_term_by( 'slug', $slug, 'product_cat' );
						if ( $term ) { $count = $term->count; }
					}
					?>
					<a class="category-tile" href="<?php echo esc_url( $cat_url ); ?>">
						<img class="category-tile__icon" src="<?php echo esc_url( $cat['icon'] ); ?>" alt="" aria-hidden="true" width="48" height="48" loading="lazy">
						<span class="category-tile__label"><?php echo esc_html( $cat['label'] ); ?></span>
						<?php if ( $count > 0 ) : ?>
							<span class="category-tile__count"><?php printf( esc_html( _n( '%d product', '%d products', $count, 'cove' ) ), (int) $count ); ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- 3. New Arrivals -->
	<?php
	$cove_new = array();
	if ( function_exists( 'wc_get_products' ) ) {
		$cove_new = wc_get_products( array(
			'status'  => 'publish',
			'limit'   => 8,
			'orderby' => 'date',
			'order'   => 'DESC',
		) );
	}
	if ( ! empty( $cove_new ) ) :
		?>
		<section class="section surface-cream-deep" data-reveal>
			<div class="container">
				<div class="section-head">
					<div class="stack-sm">
						<p class="eyebrow eyebrow--amber"><?php esc_html_e( 'Just landed', 'cove' ); ?></p>
						<h2 class="t-1"><?php esc_html_e( 'New arrivals.', 'cove' ); ?></h2>
					</div>
					<a class="btn btn--outline" href="<?php echo esc_url( add_query_arg( 'orderby', 'date', $cove_shop ) ); ?>"><?php esc_html_e( 'See all new stock', 'cove' ); ?></a>
				</div>
				<ul class="products-grid">
					<?php
					$cove_card = get_theme_file_path( 'woocommerce/content-product.php' );
					foreach ( $cove_new as $cove_p ) :
						$GLOBALS['product'] = $cove_p; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
						$product            = $cove_p; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
						if ( file_exists( $cove_card ) ) { require $cove_card; }
					endforeach;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- 4. Grade Strip -->
	<section class="grade-strip" data-reveal>
		<div class="container">
			<div class="section-head" style="color:#fff; margin-bottom: var(--s-7);">
				<div class="stack-sm">
					<p class="eyebrow" style="color: var(--amber-light);"><?php esc_html_e( 'How our grades work', 'cove' ); ?></p>
					<h2 class="t-1" style="color:#fff;"><?php esc_html_e( 'Great gear, honest condition.', 'cove' ); ?></h2>
				</div>
				<a class="link-arrow" href="<?php echo esc_url( home_url( '/grades' ) ); ?>" style="color: var(--amber-light);"><?php esc_html_e( 'Grade explainer', 'cove' ); ?></a>
			</div>
			<div class="grade-strip__grid">
				<?php
				$cove_grades = array(
					'a' => array(
						'label'  => __( 'Grade A', 'cove' ),
						'desc'   => __( 'Open box or light display use. Near-perfect condition — you\'d have to look hard to find anything different from new.', 'cove' ),
						'saving' => __( 'Save up to 25%', 'cove' ),
						'slug'   => 'grade-a',
					),
					'b' => array(
						'label'  => __( 'Grade B', 'cove' ),
						'desc'   => __( 'Minor cosmetic marks — a small scratch or scuff. Fully tested and 100% functional. The sweet spot for serious savings.', 'cove' ),
						'saving' => __( 'Save up to 35%', 'cove' ),
						'slug'   => 'grade-b',
					),
					'c' => array(
						'label'  => __( 'Grade C', 'cove' ),
						'desc'   => __( 'Visible cosmetic damage — dents, marks, fading. Works perfectly. If you hide it in a cupboard, this is for you.', 'cove' ),
						'saving' => __( 'Save up to 45%', 'cove' ),
						'slug'   => 'grade-c',
					),
				);
				foreach ( $cove_grades as $key => $grade ) : ?>
					<div class="grade-strip__col grade-strip__col--<?php echo esc_attr( $key ); ?>">
						<span class="grade-strip__letter"><?php echo esc_html( strtoupper( $key ) ); ?></span>
						<p class="grade-strip__name"><?php echo esc_html( $grade['label'] ); ?></p>
						<p class="grade-strip__desc"><?php echo esc_html( $grade['desc'] ); ?></p>
						<p class="grade-strip__saving t-mono"><?php echo esc_html( $grade['saving'] ); ?></p>
						<a class="btn btn--outline grade-strip__cta btn--sm" href="<?php echo esc_url( add_query_arg( 'condition', $grade['slug'], $cove_shop ) ); ?>">
							<?php printf( esc_html__( 'Browse %s', 'cove' ), esc_html( $grade['label'] ) ); ?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- 5. Featured Deals (Grade A/B) -->
	<?php
	$cove_deals = array();
	if ( function_exists( 'wc_get_products' ) ) {
		$deal_ids = get_posts( array(
			'post_type'   => 'product',
			'post_status' => 'publish',
			'numberposts' => 3,
			'tax_query'   => array( array( // phpcs:ignore WordPress.DB.SlowDBQuery
				'taxonomy' => 'product_condition',
				'field'    => 'slug',
				'terms'    => array( 'grade-a', 'grade-b' ),
			) ),
			'fields'      => 'ids',
		) );
		foreach ( $deal_ids as $did ) {
			$p = wc_get_product( $did );
			if ( $p ) { $cove_deals[] = $p; }
		}
	}
	if ( ! empty( $cove_deals ) ) : ?>
		<section class="section" data-reveal>
			<div class="container">
				<div class="section-head">
					<div class="stack-sm">
						<p class="eyebrow eyebrow--amber"><?php esc_html_e( 'This week\'s deals', 'cove' ); ?></p>
						<h2 class="t-1"><?php esc_html_e( 'Grade deals, big savings.', 'cove' ); ?></h2>
					</div>
					<a class="link-arrow" href="<?php echo esc_url( add_query_arg( 'orderby', 'saving', $cove_shop ) ); ?>"><?php esc_html_e( 'All deals', 'cove' ); ?></a>
				</div>
				<ul class="products-grid products-grid--3">
					<?php
					foreach ( $cove_deals as $cove_p ) :
						$GLOBALS['product'] = $cove_p; // phpcs:ignore
						$product            = $cove_p; // phpcs:ignore
						if ( isset( $cove_card ) && file_exists( $cove_card ) ) { require $cove_card; }
					endforeach;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- 6. Trust Bar -->
	<section class="trust-bar" data-reveal>
		<div class="container">
			<ul class="trust-grid">
				<?php
				$cove_trust = array(
					array(
						'icon'  => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
						'title' => __( '90-day warranty', 'cove' ),
						'desc'  => __( 'On all Grade A, B and C stock. 2 years on new.', 'cove' ),
					),
					array(
						'icon'  => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
						'title' => __( 'Tested & certified', 'cove' ),
						'desc'  => __( 'Every unit runs through a full functionality check before listing.', 'cove' ),
					),
					array(
						'icon'  => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>',
						'title' => __( '30-day returns', 'cove' ),
						'desc'  => __( 'Changed your mind? Return any item within 30 days.', 'cove' ),
					),
					array(
						'icon'  => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
						'title' => __( 'Free shipping over R800', 'cove' ),
						'desc'  => __( 'Nationwide delivery on qualifying orders.', 'cove' ),
					),
				);
				foreach ( $cove_trust as $item ) :
					?>
					<li class="trust-item">
						<div class="trust-item__icon"><?php echo $item['icon']; // phpcs:ignore ?></div>
						<p class="trust-item__title"><?php echo esc_html( $item['title'] ); ?></p>
						<p class="trust-item__desc"><?php echo esc_html( $item['desc'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 7. Reviews -->
	<section class="section" data-reveal>
		<div class="container">
			<div class="section-head">
				<div class="stack-sm">
					<p class="eyebrow"><?php esc_html_e( 'From our customers', 'cove' ); ?></p>
					<h2 class="t-1"><?php esc_html_e( 'Real homes. Real savings.', 'cove' ); ?></h2>
				</div>
				<p class="t-mono muted"><?php esc_html_e( '4.9 / 5 · 800+ reviews', 'cove' ); ?></p>
			</div>
			<div class="reviews-layout">
				<blockquote class="review-card review-card--hero">
					<p class="review-stars" aria-label="<?php esc_attr_e( '5 out of 5', 'cove' ); ?>">★★★★★</p>
					<div class="review-text">
						<p>"<?php esc_html_e( 'I bought a Grade B washing machine — the scratch on the side is behind the machine, I\'ve never even seen it. Saved R1 800 and it runs perfectly.', 'cove' ); ?>"</p>
					</div>
					<footer class="review-who">
						<strong><?php esc_html_e( 'Nandi M.', 'cove' ); ?></strong>
						<span> · <?php esc_html_e( 'Johannesburg', 'cove' ); ?></span>
						<span class="review-grade t-mono"> · <?php esc_html_e( 'Grade B', 'cove' ); ?></span>
					</footer>
				</blockquote>
				<div class="reviews-stack">
					<blockquote class="review-card">
						<p class="review-stars" aria-label="<?php esc_attr_e( '5 out of 5', 'cove' ); ?>">★★★★★</p>
						<div class="review-text">
							<p>"<?php esc_html_e( 'Grade A air purifier. Couldn\'t tell it from new. The honest description is what convinced me to buy — no surprises.', 'cove' ); ?>"</p>
						</div>
						<footer class="review-who">
							<strong><?php esc_html_e( 'Rowan T.', 'cove' ); ?></strong>
							<span> · <?php esc_html_e( 'Cape Town', 'cove' ); ?></span>
						</footer>
					</blockquote>
					<blockquote class="review-card">
						<p class="review-stars" aria-label="<?php esc_attr_e( '5 out of 5', 'cove' ); ?>">★★★★★</p>
						<div class="review-text">
							<p>"<?php esc_html_e( 'New coffee machine, delivered next day. The COVE Edit blog even helped me pick the right one. Brilliant service.', 'cove' ); ?>"</p>
						</div>
						<footer class="review-who">
							<strong><?php esc_html_e( 'Priya K.', 'cove' ); ?></strong>
							<span> · <?php esc_html_e( 'Durban', 'cove' ); ?></span>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
	</section>

	<!-- 8. The COVE Edit (Blog) -->
	<?php
	$cove_posts = new WP_Query( array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	) );
	if ( $cove_posts->have_posts() ) : ?>
		<section class="section surface-cream-deep" data-reveal>
			<div class="container">
				<div class="section-head">
					<div class="stack-sm">
						<p class="eyebrow eyebrow--amber"><?php esc_html_e( 'The COVE Edit', 'cove' ); ?></p>
						<h2 class="t-1"><?php esc_html_e( 'Buying guides & tips.', 'cove' ); ?></h2>
					</div>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/blog' ) ); ?>"><?php esc_html_e( 'Read the blog', 'cove' ); ?></a>
				</div>
				<div class="post-grid">
					<?php while ( $cove_posts->have_posts() ) :
						$cove_posts->the_post();
						if ( function_exists( 'cove_post_card' ) ) { cove_post_card( get_post() ); }
					endwhile;
					wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 9. Closing CTA -->
	<section class="home-closing" data-reveal>
		<div class="container stack" style="align-items:center;">
			<p class="eyebrow" style="color: var(--amber-light);"><?php esc_html_e( 'Ready to upgrade your home?', 'cove' ); ?></p>
			<h2 class="t-hero"><?php esc_html_e( 'Great appliances shouldn\'t cost the earth.', 'cove' ); ?></h2>
			<p class="t-lead"><?php esc_html_e( 'Browse new stock or explore Grade deals — every product honestly described, every price genuinely good.', 'cove' ); ?></p>
			<div class="cluster" style="justify-content:center;">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $cove_shop ); ?>"><?php esc_html_e( 'Shop all products', 'cove' ); ?></a>
				<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Learn about our grades', 'cove' ); ?></a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
