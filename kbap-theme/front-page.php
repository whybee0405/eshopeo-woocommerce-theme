<?php
/**
 * K-BAP homepage.
 *
 * @package KBAP
 */

get_header();
$menu_url     = home_url( '/menu/' );
$catering_url = home_url( '/catering/' );
$shop_url     = kbap_wc_active() && function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
$hero_dishes  = kbap_hero_table_dishes();
?>

<section class="hero hero--table" data-table-hero>
	<div class="container table-hero">
		<div class="table-hero__copy reveal">
			<p class="eyebrow"><?php esc_html_e( 'Johannesburg Korean catering', 'kbap' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'Meet the table before you book it.', 'kbap' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Tap or hover over the dishes to see serving notes, starting prices and what belongs on a K-BAP catering table.', 'kbap' ); ?></p>
			<div class="hero-cta">
				<a class="btn btn--primary" href="<?php echo esc_url( $catering_url ); ?>"><?php esc_html_e( 'Request catering', 'kbap' ); ?></a>
				<a class="btn" href="<?php echo esc_url( $menu_url ); ?>"><?php esc_html_e( 'Explore the menu', 'kbap' ); ?></a>
			</div>
		</div>

		<div class="table-stage reveal">
			<div class="table-stage__image">
				<img src="<?php echo esc_url( get_theme_file_uri( 'images/interactive-table.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Overhead Korean catering table with fried chicken, gimbap, samgak gimbap, tteokbokki, japchae, bulgogi, short rib stew and kimchi.', 'kbap' ); ?>">
				<?php foreach ( $hero_dishes as $index => $dish ) : ?>
					<a
						class="dish-hotspot <?php echo 0 === $index ? 'is-active' : ''; ?>"
						href="<?php echo esc_url( $dish['url'] ); ?>"
						style="--x: <?php echo esc_attr( $dish['x'] ); ?>%; --y: <?php echo esc_attr( $dish['y'] ); ?>%;"
						data-dish-hotspot
						data-dish-id="<?php echo esc_attr( $dish['id'] ); ?>"
						data-title="<?php echo esc_attr( $dish['title'] ); ?>"
						data-desc="<?php echo esc_attr( $dish['desc'] ); ?>"
						data-price="<?php echo esc_attr( $dish['price'] ); ?>"
						data-meta="<?php echo esc_attr( $dish['meta'] ); ?>"
						aria-describedby="hero-dish-panel"
					>
						<span><?php echo esc_html( $index + 1 ); ?></span>
						<span class="screen-reader-text"><?php echo esc_html( $dish['title'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>

			<aside class="dish-panel" id="hero-dish-panel" data-dish-panel aria-live="polite">
				<p class="dish-panel__kicker"><?php esc_html_e( 'On the table', 'kbap' ); ?></p>
				<h2 data-dish-title><?php echo esc_html( $hero_dishes[0]['title'] ); ?></h2>
				<p data-dish-desc><?php echo esc_html( $hero_dishes[0]['desc'] ); ?></p>
				<div class="dish-panel__meta">
					<span data-dish-price><?php echo esc_html( $hero_dishes[0]['price'] ); ?></span>
					<span data-dish-meta><?php echo esc_html( $hero_dishes[0]['meta'] ); ?></span>
				</div>
				<a class="dish-panel__link" href="<?php echo esc_url( $hero_dishes[0]['url'] ); ?>" data-dish-link><?php esc_html_e( 'View details', 'kbap' ); ?></a>
			</aside>
		</div>

		<div class="dish-rail reveal" aria-label="<?php esc_attr_e( 'Signature dishes', 'kbap' ); ?>">
			<?php foreach ( $hero_dishes as $index => $dish ) : ?>
				<a
					class="dish-rail__item <?php echo 0 === $index ? 'is-active' : ''; ?>"
					href="<?php echo esc_url( $dish['url'] ); ?>"
					data-dish-rail
					data-dish-id="<?php echo esc_attr( $dish['id'] ); ?>"
					data-title="<?php echo esc_attr( $dish['title'] ); ?>"
					data-desc="<?php echo esc_attr( $dish['desc'] ); ?>"
					data-price="<?php echo esc_attr( $dish['price'] ); ?>"
					data-meta="<?php echo esc_attr( $dish['meta'] ); ?>"
				>
					<span><?php echo esc_html( $dish['title'] ); ?></span>
					<strong><?php echo esc_html( $dish['price'] ); ?></strong>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="trust-band" aria-label="<?php esc_attr_e( 'Trusted catering proof', 'kbap' ); ?>">
	<div class="container trust-band__inner reveal">
		<span><?php esc_html_e( 'Korean Embassy events', 'kbap' ); ?></span>
		<span><?php esc_html_e( 'Korean Association events', 'kbap' ); ?></span>
		<span><?php esc_html_e( 'Korean Cultural Centre events', 'kbap' ); ?></span>
		<span><?php esc_html_e( 'KFFF participant', 'kbap' ); ?></span>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Most requested', 'kbap' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Food people remember after the event.', 'kbap' ); ?></h2>
			</div>
			<p class="lead"><?php esc_html_e( 'The menu works for Korean guests looking for familiar flavours and South African guests meeting Korean food properly for the first time.', 'kbap' ); ?></p>
		</div>
		<div class="dish-grid">
			<?php foreach ( kbap_featured_dishes() as $index => $dish ) : ?>
				<article class="dish-card <?php echo 0 === $index ? 'dish-card--feature' : ''; ?> reveal">
					<a class="dish-card__media" href="<?php echo esc_url( $menu_url ); ?>">
						<img src="<?php echo esc_url( get_theme_file_uri( $dish['image'] ) ); ?>" alt="<?php echo esc_attr( $dish['title'] ); ?>">
					</a>
					<div class="dish-card__body">
						<h3><?php echo esc_html( $dish['title'] ); ?></h3>
						<p class="muted"><?php echo esc_html( $dish['text'] ); ?></p>
						<div class="dish-meta">
							<?php foreach ( $dish['tags'] as $tag ) : ?>
								<span><?php echo esc_html( $tag ); ?></span>
							<?php endforeach; ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--cream">
	<div class="container">
		<div class="section-head reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Catering formats', 'kbap' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Packages for teams, festivals and formal tables.', 'kbap' ); ?></h2>
			</div>
			<a class="btn btn--dark" href="<?php echo esc_url( $catering_url ); ?>"><?php esc_html_e( 'Plan an event', 'kbap' ); ?></a>
		</div>
		<div class="trust-grid">
			<?php foreach ( kbap_catering_packages() as $package ) : ?>
				<article class="trust-item reveal">
					<p class="eyebrow"><?php echo esc_html( $package['serves'] ); ?></p>
					<h3><?php echo esc_html( $package['name'] ); ?></h3>
					<p class="muted"><?php echo esc_html( $package['summary'] ); ?></p>
					<p><strong><?php echo esc_html( $package['price'] ); ?></strong></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--dark">
	<div class="container">
		<div class="section-head reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Product future', 'kbap' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Kimchi, meal kits and pantry stock belong here too.', 'kbap' ); ?></h2>
			</div>
			<p class="lead" style="color:rgba(247,242,232,.72)"><?php esc_html_e( 'WooCommerce is ready for K-BAP Kimchi, samgak gimbap market drops, bulgogi kits, sauces, and catering packs when the brand expands into local markets and online sales.', 'kbap' ); ?></p>
		</div>
		<div class="product-grid">
			<article class="product-teaser reveal">
				<div class="product-teaser__media"><img src="<?php echo esc_url( get_theme_file_uri( 'images/kimchi-product.png' ) ); ?>" alt="<?php esc_attr_e( 'K-BAP Kimchi jar product mockup.', 'kbap' ); ?>"></div>
				<div class="product-teaser__body">
					<h3><?php esc_html_e( 'K-BAP Kimchi', 'kbap' ); ?></h3>
					<p class="muted"><?php esc_html_e( 'Small-batch napa cabbage kimchi, loved by regulars and event guests.', 'kbap' ); ?></p>
				</div>
			</article>
			<article class="product-teaser reveal">
				<div class="product-teaser__media"><img src="<?php echo esc_url( get_theme_file_uri( 'images/event-table.png' ) ); ?>" alt="<?php esc_attr_e( 'Samgak gimbap, japchae, bulgogi and kimchi on a catering table.', 'kbap' ); ?>"></div>
				<div class="product-teaser__body">
					<h3><?php esc_html_e( 'Meal kits', 'kbap' ); ?></h3>
					<p class="muted"><?php esc_html_e( 'Future home-cook kits for bulgogi, tteokbokki, japchae and short rib stew.', 'kbap' ); ?></p>
				</div>
			</article>
			<article class="product-teaser reveal">
				<div class="product-teaser__media"><img src="<?php echo esc_url( get_theme_file_uri( 'images/fried-chicken.png' ) ); ?>" alt="<?php esc_attr_e( 'Korean fried chicken with sesame and pickled radish.', 'kbap' ); ?>"></div>
				<div class="product-teaser__body">
					<h3><?php esc_html_e( 'Catering packs', 'kbap' ); ?></h3>
					<p class="muted"><?php esc_html_e( 'Pre-built bundles for office lunches, private dinners and market activations.', 'kbap' ); ?></p>
				</div>
			</article>
		</div>
	</div>
</section>

<?php get_footer(); ?>
