<?php
/**
 * Homepage — the section order IS the customer journey:
 * hero → routine rail → concern tiles → best sellers → sourcing →
 * ingredient index → reviews → newsletter.
 *
 * @package Glow_KBeauty
 */

get_header();

/*
 * If Elementor has taken over this page, hand off entirely and exit.
 * Clients build the homepage by dragging Glow K-Beauty widgets into
 * Elementor sections — the hardcoded design below is the no-Elementor
 * fallback and the built-in demo until Elementor is configured.
 */
if ( glow_is_elementor_page() ) {
	echo '<main id="main">';
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	echo '</main>';
	get_footer();
	return;
}

/*
 * Hero stage products, keyed by routine step. These reference bundled
 * theme SVGs directly so the signature interaction works before any
 * media has been uploaded. Names and prices match the bundled importer.
 */
$glow_stages = array(
	1 => array(
		'brand' => 'COSRX',
		'name'  => __( 'Low pH Good Morning Gel Cleanser', 'glow-glow' ),
		'price' => 'R295',
		'svg'   => 'product-step-01.jpg',
		'tone'  => 'tone-seafoam',
	),
	2 => array(
		'brand' => 'COSRX',
		'name'  => __( 'BHA Blackhead Power Liquid', 'glow-glow' ),
		'price' => 'R385',
		'svg'   => 'product-step-02.jpg',
		'tone'  => 'tone-petal',
	),
	3 => array(
		'brand' => 'COSRX',
		'name'  => __( 'Advanced Snail 96 Mucin Power Essence', 'glow-glow' ),
		'price' => 'R450',
		'svg'   => 'product-step-03.jpg',
		'tone'  => 'tone-rice-deep',
	),
	4 => array(
		'brand' => 'Klairs',
		'name'  => __( 'Freshly Juiced Vitamin Drop', 'glow-glow' ),
		'price' => 'R430',
		'svg'   => 'product-step-04.jpg',
		'tone'  => 'tone-seafoam',
	),
	5 => array(
		'brand' => 'Laneige',
		'name'  => __( 'Water Bank Blue Hyaluronic Cream', 'glow-glow' ),
		'price' => 'R750',
		'svg'   => 'product-step-05.jpg',
		'tone'  => 'tone-petal',
	),
	6 => array(
		'brand' => 'AHC',
		'name'  => __( 'Ageless Real Eye Cream For Face', 'glow-glow' ),
		'price' => 'R340',
		'svg'   => 'product-step-06.jpg',
		'tone'  => 'tone-rice-deep',
	),
	7 => array(
		'brand' => 'Innisfree',
		'name'  => __( 'Daily UV Defense Sunscreen SPF36+', 'glow-glow' ),
		'price' => 'R330',
		'svg'   => 'product-step-07.jpg',
		'tone'  => 'tone-seafoam',
	),
);

$glow_steps    = glow_routine_steps();
$glow_shop_url = glow_wc_active() ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$glow_brand_logos = array(
	array( 'name' => 'Anua', 'file' => 'anua.png' ),
	array( 'name' => 'Banila Co', 'file' => 'banila co.png' ),
	array( 'name' => 'Beauty of Joseon', 'file' => 'beauty of joseon.png' ),
	array( 'name' => 'COSRX', 'file' => 'cosrx.png' ),
	array( 'name' => 'Etude', 'file' => 'etude.png' ),
	array( 'name' => 'Innisfree', 'file' => 'innisfree.png' ),
	array( 'name' => 'Klairs', 'file' => 'klairs.png' ),
	array( 'name' => 'Laneige', 'file' => 'laneige.png' ),
	array( 'name' => 'Mediheal', 'file' => 'mediheal.png' ),
	array( 'name' => 'Missha', 'file' => 'missha.png' ),
	array( 'name' => 'Round Lab', 'file' => 'round lab.png' ),
	array( 'name' => 'Skin1004', 'file' => 'skin1004.png' ),
	array( 'name' => 'Torriden', 'file' => 'torriden.png' ),
);
?>

<main id="main">

	<!-- 1. Hero -->
	<section class="hero">
		<div class="container hero-grid">

			<div class="hero-copy">
				<h1 class="t-hero"><?php echo wp_kses( __( 'Premium Korean skincare, <em>made simple.</em>', 'glow-glow' ), array( 'em' => array() ) ); ?></h1>
				<p class="lead"><?php esc_html_e( 'Authentic Korean skincare, thoughtfully curated and clearly explained. Search by ingredient, concern or product type, then build daily care with confidence.', 'glow-glow' ); ?></p>

				<?php
				$glow_hero_sc = get_theme_mod( 'glow_hero_shortcode', '[eshopeo_search]' );
				if ( $glow_hero_sc ) :
					?>
					<div class="hero-search" aria-label="<?php esc_attr_e( 'AI skincare search', 'glow-glow' ); ?>">
						<?php echo do_shortcode( wp_kses_post( $glow_hero_sc ) ); ?>
					</div>
				<?php endif; ?>

				<div class="hero-ctas">
					<a class="btn btn-yuja" href="<?php echo esc_url( $glow_shop_url ); ?>"><?php esc_html_e( 'Shop Korean skincare', 'glow-glow' ); ?></a>
					<a class="btn btn-outline" href="#routine"><?php esc_html_e( 'Find your daily care', 'glow-glow' ); ?></a>
				</div>

				<p class="hero-footnote">
					<span><?php echo esc_html( get_theme_mod( 'glow_trust_1', __( 'Authentic Korean skincare', 'glow-glow' ) ) ); ?></span>
					<span><?php echo esc_html( get_theme_mod( 'glow_trust_2', __( 'Ingredient-focused guidance', 'glow-glow' ) ) ); ?></span>
					<span><?php echo esc_html( get_theme_mod( 'glow_trust_3', __( 'Ships from Joburg', 'glow-glow' ) ) ); ?></span>
				</p>
			</div>

			<div class="hero-stage tone-seafoam" data-hero-stage aria-live="polite">
				<?php foreach ( $glow_stages as $step_no => $stage ) : ?>
					<?php $step = $glow_steps[ $step_no - 1 ]; ?>
					<div class="stage-item<?php echo 1 === $step_no ? ' is-active' : ''; ?>" data-stage="<?php echo (int) $step_no; ?>" data-tone="<?php echo esc_attr( $stage['tone'] ); ?>">
						<span class="stage-tag">STEP <?php echo esc_html( $step['no'] ); ?> · <?php echo esc_html( $step['name'] ); ?></span>
						<div class="stage-media">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/products/' . $stage['svg'] ); ?>" alt="<?php echo esc_attr( $stage['brand'] . ' ' . $stage['name'] ); ?>" width="600" height="600" />
						</div>
						<a class="stage-meta" href="<?php echo esc_url( glow_step_url( $step['slug'] ) ); ?>">
							<span class="stage-name">
								<span class="stage-brand"><?php echo esc_html( $stage['brand'] ); ?></span>
								<?php echo esc_html( $stage['name'] ); ?>
							</span>
							<span class="stage-price mono"><?php echo esc_html( $stage['price'] ); ?></span>
						</a>
					</div>
				<?php endforeach; ?>
				<button class="stage-nav stage-prev" type="button" aria-label="<?php esc_attr_e( 'Previous step', 'glow-glow' ); ?>" data-stage-prev>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
				</button>
				<button class="stage-nav stage-next" type="button" aria-label="<?php esc_attr_e( 'Next step', 'glow-glow' ); ?>" data-stage-next>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
				</button>
			</div>

		</div>
	</section>

	<!-- 1.5 Brand logo loop -->
	<section class="brand-loop-section" aria-label="<?php esc_attr_e( 'Korean beauty brands featured on Glow', 'glow-glow' ); ?>">
		<div class="container">
			<div class="brand-loop-shell" data-reveal>
				<p class="brand-loop-label"><?php esc_html_e( 'Cult Korean skincare names, one routine-first edit.', 'glow-glow' ); ?></p>
				<div class="brand-loop" style="--brand-loop-duration: 42s;">
					<div class="brand-loop-track">
						<?php for ( $copy = 0; $copy < 2; $copy++ ) : ?>
							<ul class="brand-loop-list" <?php echo $copy > 0 ? 'aria-hidden="true"' : ''; ?>>
								<?php foreach ( $glow_brand_logos as $glow_brand ) : ?>
									<?php
									$glow_brand_name = $glow_brand['name'];
									$glow_brand_url = add_query_arg(
										array(
											's'         => rawurlencode( $glow_brand_name ),
											'post_type' => 'product',
										),
										home_url( '/' )
									);
									?>
									<li class="brand-loop-item">
										<a class="brand-loop-mark" href="<?php echo esc_url( $glow_brand_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Shop %s products', 'glow-glow' ), $glow_brand_name ) ); ?>">
											<span
												class="brand-loop-logo"
												style="--brand-logo: url('<?php echo esc_url( get_template_directory_uri() . '/images/product brands/' . $glow_brand['file'] ); ?>');"
												role="img"
												aria-label="<?php echo esc_attr( $glow_brand_name ); ?>"
											></span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 2. The Routine Rail (signature) -->
	<?php glow_routine_rail( true ); ?>

	<!-- 3. Shop by concern -->
	<section class="section">
		<div class="container">
			<h2 class="t-1" data-reveal><?php esc_html_e( 'In a hurry? Shop by concern.', 'glow-glow' ); ?></h2>

			<ol class="concern-list" data-reveal>
				<li>
					<a class="concern-row" href="<?php echo esc_url( glow_tax_url( 'dehydrated-dull', 'skin_concern' ) ); ?>">
						<span class="concern-no" aria-hidden="true">01</span>
						<span class="concern-image" aria-hidden="true">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/products/product-step-05.jpg' ); ?>" alt="" width="600" height="600" loading="lazy" decoding="async" />
						</span>
						<span>
							<span class="concern-name"><?php esc_html_e( 'Dehydrated & dull', 'glow-glow' ); ?></span>
							<span class="concern-desc"><?php esc_html_e( 'Skin that drinks moisturiser and still looks tired by 3pm. Humectants and rice extract first.', 'glow-glow' ); ?></span>
						</span>
						<span class="concern-arrow" aria-hidden="true">→</span>
					</a>
				</li>
				<li>
					<a class="concern-row" href="<?php echo esc_url( glow_tax_url( 'breakouts-texture', 'skin_concern' ) ); ?>">
						<span class="concern-no" aria-hidden="true">02</span>
						<span class="concern-image" aria-hidden="true">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/products/product-step-02.jpg' ); ?>" alt="" width="600" height="600" loading="lazy" decoding="async" />
						</span>
						<span>
							<span class="concern-name"><?php esc_html_e( 'Breakouts & texture', 'glow-glow' ); ?></span>
							<span class="concern-desc"><?php esc_html_e( 'Congestion, bumps and marks that overstay. BHA, tea tree and patience, in that order.', 'glow-glow' ); ?></span>
						</span>
						<span class="concern-arrow" aria-hidden="true">→</span>
					</a>
				</li>
				<li>
					<a class="concern-row" href="<?php echo esc_url( glow_tax_url( 'fine-lines-firmness', 'skin_concern' ) ); ?>">
						<span class="concern-no" aria-hidden="true">03</span>
						<span class="concern-image" aria-hidden="true">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/products/product-step-03.jpg' ); ?>" alt="" width="600" height="600" loading="lazy" decoding="async" />
						</span>
						<span>
							<span class="concern-name"><?php esc_html_e( 'Fine lines & firmness', 'glow-glow' ); ?></span>
							<span class="concern-desc"><?php esc_html_e( 'Peptides, snail mucin and daily SPF. The long game.', 'glow-glow' ); ?></span>
						</span>
						<span class="concern-arrow" aria-hidden="true">→</span>
					</a>
				</li>
				<li>
					<a class="concern-row" href="<?php echo esc_url( glow_tax_url( 'sensitive-reactive', 'skin_concern' ) ); ?>">
						<span class="concern-no" aria-hidden="true">04</span>
						<span class="concern-image" aria-hidden="true">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/products/product-step-04.jpg' ); ?>" alt="" width="600" height="600" loading="lazy" decoding="async" />
						</span>
						<span>
							<span class="concern-name"><?php esc_html_e( 'Sensitive & reactive', 'glow-glow' ); ?></span>
							<span class="concern-desc"><?php esc_html_e( 'Everything here is fragrance-checked. Full ingredient lists, no guessing.', 'glow-glow' ); ?></span>
						</span>
						<span class="concern-arrow" aria-hidden="true">→</span>
					</a>
				</li>
			</ol>
		</div>
	</section>

	<!-- 4. Best sellers -->
	<?php if ( glow_wc_active() ) : ?>
		<?php
		$glow_featured = wc_get_products(
			array(
				'status'   => 'publish',
				'featured' => true,
				'limit'    => 4,
			)
		);

		if ( count( $glow_featured ) < 4 ) {
			$glow_featured = wc_get_products(
				array(
					'status'  => 'publish',
					'limit'   => 4,
					'orderby' => 'date',
					'order'   => 'DESC',
				)
			);
		}
		?>
		<?php if ( $glow_featured ) : ?>
			<section class="section section-tight">
				<div class="container">
					<div class="section-head" data-reveal>
						<h2 class="t-1"><?php esc_html_e( 'Best sellers', 'glow-glow' ); ?></h2>
						<a class="link-arrow head-aside" href="<?php echo esc_url( $glow_shop_url ); ?>"><?php esc_html_e( 'Shop everything', 'glow-glow' ); ?> <span class="arrow" aria-hidden="true">→</span></a>
					</div>

					<ul class="products grid-4" data-reveal>
						<?php
						foreach ( $glow_featured as $glow_product ) {
							$post_object = get_post( $glow_product->get_id() );
							setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
							wc_get_template_part( 'content', 'product' );
						}
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>

	<!-- 4.5 Lifestyle band -->
	<section class="lifestyle-band" data-reveal>
		<div class="lifestyle-band-bg" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/images/people/lifestyle.jpg' ); ?>')"></div>
		<div class="lifestyle-band-content">
			<p class="lifestyle-eyebrow"><?php esc_html_e( 'Healthy skin, clearly understood.', 'glow-glow' ); ?></p>
			<p class="lifestyle-stat"><?php echo wp_kses( __( '<strong>4 200+</strong> customers guided toward calmer daily care.', 'glow-glow' ), array( 'strong' => array() ) ); ?></p>
		</div>
	</section>

	<!-- 5. Sourcing split -->
	<section class="section">
		<div class="container">
			<div class="sourcing-split" data-reveal>
				<div class="sourcing-media sourcing-media--bright" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/images/hero/hero-korean-beauty.png' ); ?>')">
					<ul class="supply-line">
						<li><span class="mono"><?php esc_html_e( 'Seoul', 'glow-glow' ); ?></span> <?php esc_html_e( 'Bought directly from brands and licensed distributors', 'glow-glow' ); ?></li>
						<li><span class="mono"><?php esc_html_e( 'In transit', 'glow-glow' ); ?></span> <?php esc_html_e( 'Temperature-stable air freight, never sea containers', 'glow-glow' ); ?></li>
						<li><span class="mono"><?php esc_html_e( 'Joburg', 'glow-glow' ); ?></span> <?php esc_html_e( 'Batch numbers logged and checked against brand records', 'glow-glow' ); ?></li>
						<li><span class="mono"><?php esc_html_e( 'Your door', 'glow-glow' ); ?></span> <?php esc_html_e( 'Tracked courier, 1–5 working days nationwide', 'glow-glow' ); ?></li>
					</ul>
				</div>
				<div class="sourcing-body">
					<h2 class="t-1"><?php esc_html_e( 'Authentic Korean skincare, without the guesswork.', 'glow-glow' ); ?></h2>
					<p class="lead"><?php esc_html_e( 'We buy from Korean brands and licensed distributors, keep batch records, and explain ingredients in plain language. You get clarity before you commit.', 'glow-glow' ); ?></p>
					<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'How we source', 'glow-glow' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- 6. Ingredient Index -->
	<section class="section section-tight" id="ingredients">
		<div class="container">
			<div class="section-head" data-reveal>
				<h2 class="t-1"><?php esc_html_e( 'Shop by what\'s inside', 'glow-glow' ); ?></h2>
				<p class="head-aside lead"><?php esc_html_e( 'The five actives we get asked about most, and what they actually do.', 'glow-glow' ); ?></p>
			</div>

			<ul class="ingredient-index" data-reveal>
				<?php
				$glow_ingredients = array(
					array( __( 'Snail mucin', 'glow-glow' ), __( 'Repair and bounce — the texture people side-eye, then swear by', 'glow-glow' ), 'snail mucin' ),
					array( __( 'Centella asiatica', 'glow-glow' ), __( 'Calms redness and irritation; the sensitive-skin workhorse', 'glow-glow' ), 'centella' ),
					array( __( 'Niacinamide', 'glow-glow' ), __( 'Evens tone, blurs pores, plays well with nearly everything', 'glow-glow' ), 'niacinamide' ),
					array( __( 'Hyaluronic acid', 'glow-glow' ), __( 'Pulls water into skin — the fix for tight, thirsty afternoons', 'glow-glow' ), 'hyaluronic' ),
					array( __( 'Rice extract', 'glow-glow' ), __( 'Gentle brightening, centuries before it was a trend', 'glow-glow' ), 'rice extract' ),
				);

				foreach ( $glow_ingredients as $i => $glow_ing ) :
					$glow_search = add_query_arg(
						array(
							's'         => rawurlencode( $glow_ing[2] ),
							'post_type' => 'product',
						),
						home_url( '/' )
					);
					?>
					<li>
						<a class="index-row" href="<?php echo esc_url( $glow_search ); ?>">
							<span class="index-no"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="index-name"><?php echo esc_html( $glow_ing[0] ); ?></span>
							<span class="index-for"><?php echo esc_html( $glow_ing[1] ); ?></span>
							<span class="arrow" aria-hidden="true">→</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 7. Reviews -->
	<section class="reviews-section">
		<div class="container">
			<figure class="pull-review" data-reveal>
				<blockquote>
					<p class="pull-stars" aria-label="<?php esc_attr_e( '5 stars', 'glow-glow' ); ?>">★★★★★</p>
					<p class="pull-quote-text"><?php esc_html_e( '"I had tried Korean skincare before, but never knew what went with what. Glow made the ingredients and order feel simple enough to trust."', 'glow-glow' ); ?></p>
					<footer class="pull-who">
						<div class="pull-avatar" aria-hidden="true">
							<?php
							$glow_naledi_img = get_template_directory_uri() . '/images/people/naledi.jpg';
							?>
							<img src="<?php echo esc_url( $glow_naledi_img ); ?>" alt="" width="44" height="44" onerror="this.style.display='none'" />
							<span>N</span>
						</div>
						<div class="pull-who-text">
							<span class="pull-name"><?php esc_html_e( 'Naledi M.', 'glow-glow' ); ?></span>
							<span class="pull-detail"><?php esc_html_e( 'Sandton · First Korean skincare routine', 'glow-glow' ); ?></span>
						</div>
					</footer>
				</blockquote>
				<div class="review-aside">
					<p class="review-aside-item">
						<?php esc_html_e( '"My skin reacts to everything. I got an ingredient-by-ingredient answer the same day I emailed. Zero drama since."', 'glow-glow' ); ?>
						<cite><?php esc_html_e( 'Sarah V. — Cape Town', 'glow-glow' ); ?></cite>
					</p>
					<p class="review-aside-item">
						<?php esc_html_e( '"I know nothing about skincare and didn\'t need to. Arrived in two days, beautifully packed. She\'s already reordered twice."', 'glow-glow' ); ?>
						<cite><?php esc_html_e( 'Thabo K. — Pretoria', 'glow-glow' ); ?></cite>
					</p>
				</div>
			</figure>
		</div>
	</section>

	<!-- 8. Newsletter -->
	<section class="newsletter-section">
		<div class="container">
			<div class="newsletter-inner" data-reveal>
				<p class="newsletter-eyebrow"><?php esc_html_e( 'The Glow Dispatch', 'glow-glow' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Korean skincare, explained calmly.', 'glow-glow' ); ?></h2>

				<form class="newsletter-form" data-ajax-form="glow_newsletter">
					<label class="screen-reader-text" for="glow-newsletter-email"><?php esc_html_e( 'Email address', 'glow-glow' ); ?></label>
					<input type="email" id="glow-newsletter-email" name="email" required placeholder="<?php esc_attr_e( 'your@email.co.za', 'glow-glow' ); ?>" />
					<button class="btn btn-yuja" type="submit"><?php esc_html_e( 'Sign me up', 'glow-glow' ); ?></button>
				</form>
				<p class="newsletter-privacy"><?php esc_html_e( 'No spam. Unsubscribe any time. Your details stay with us.', 'glow-glow' ); ?></p>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
