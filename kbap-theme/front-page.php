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
?>

<section class="hero">
	<div class="container hero-grid">
		<div class="hero-copy reveal">
			<p class="eyebrow"><?php esc_html_e( 'Johannesburg Korean catering', 'kbap' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'Korean food with proof behind it.', 'kbap' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'K-BAP caters Korean fried chicken, gimbap, tteokbokki, bulgogi, japchae, short rib stew, kimchi and event tables for South African guests who want the real thing.', 'kbap' ); ?></p>
			<div class="hero-cta">
				<a class="btn btn--primary" href="<?php echo esc_url( $catering_url ); ?>"><?php esc_html_e( 'Request catering', 'kbap' ); ?></a>
				<a class="btn" href="<?php echo esc_url( $menu_url ); ?>"><?php esc_html_e( 'Explore the menu', 'kbap' ); ?></a>
			</div>
			<div class="proof-strip" aria-label="<?php esc_attr_e( 'Trust proof', 'kbap' ); ?>">
				<span><?php esc_html_e( 'Korean Embassy events', 'kbap' ); ?></span>
				<span><?php esc_html_e( 'Korean Association events', 'kbap' ); ?></span>
				<span><?php esc_html_e( 'Korean Cultural Centre events', 'kbap' ); ?></span>
				<span><?php esc_html_e( 'KFFF participant', 'kbap' ); ?></span>
			</div>
		</div>
		<div class="hero-media reveal">
			<img src="<?php echo esc_url( get_theme_file_uri( 'images/hero-catering.png' ) ); ?>" alt="<?php esc_attr_e( 'Korean catering spread with fried chicken, gimbap, tteokbokki, japchae and kimchi.', 'kbap' ); ?>">
			<div class="hero-ticket">
				<div>
					<strong><?php esc_html_e( 'Catering now, products next.', 'kbap' ); ?></strong>
					<span><?php esc_html_e( 'K-BAP Kimchi, meal kits and local market stock are built into the shop path.', 'kbap' ); ?></span>
				</div>
				<a class="btn btn--primary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Future shop', 'kbap' ); ?></a>
			</div>
		</div>
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
			<?php foreach ( kbap_featured_dishes() as $dish ) : ?>
				<article class="dish-card reveal">
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
