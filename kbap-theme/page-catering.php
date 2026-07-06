<?php
/**
 * Template Name: Catering
 *
 * @package KBAP
 */

get_header();
?>
<section class="hero">
	<div class="container hero-grid">
		<div class="hero-copy reveal">
			<p class="eyebrow"><?php esc_html_e( 'Catering', 'kbap' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'A Korean table that can hold the room.', 'kbap' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'From office lunches to cultural receptions, K-BAP brings Korean food into South African event formats without flattening the flavour.', 'kbap' ); ?></p>
			<a class="btn btn--primary" href="#quote"><?php esc_html_e( 'Request a quote', 'kbap' ); ?></a>
		</div>
		<div class="hero-media reveal">
			<img src="<?php echo esc_url( get_theme_file_uri( 'images/event-table.png' ) ); ?>" alt="<?php esc_attr_e( 'Korean catering detail with samgak gimbap, japchae, short rib stew and bulgogi.', 'kbap' ); ?>">
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Packages', 'kbap' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Start with a format. We tune the menu from there.', 'kbap' ); ?></h2>
			</div>
			<p class="lead"><?php esc_html_e( 'These packages are starting points for quote requests. Service, staffing, delivery and menu detail can be adjusted per event.', 'kbap' ); ?></p>
		</div>
		<div class="trust-grid">
			<?php foreach ( kbap_catering_packages() as $package ) : ?>
				<article class="trust-item reveal">
					<p class="eyebrow"><?php echo esc_html( $package['serves'] ); ?></p>
					<h3><?php echo esc_html( $package['name'] ); ?></h3>
					<p class="muted"><?php echo esc_html( $package['summary'] ); ?></p>
					<p><strong><?php echo esc_html( $package['price'] ); ?></strong></p>
					<div class="dish-meta">
						<?php foreach ( $package['includes'] as $include ) : ?>
							<span><?php echo esc_html( $include ); ?></span>
						<?php endforeach; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--cream">
	<div class="container">
		<ol class="catering-steps reveal">
			<li><strong><?php esc_html_e( '1. Brief', 'kbap' ); ?></strong><?php esc_html_e( 'Tell us guest count, date, location, event type and dietary needs.', 'kbap' ); ?></li>
			<li><strong><?php esc_html_e( '2. Menu', 'kbap' ); ?></strong><?php esc_html_e( 'We recommend dishes that travel well and fit your audience.', 'kbap' ); ?></li>
			<li><strong><?php esc_html_e( '3. Quote', 'kbap' ); ?></strong><?php esc_html_e( 'You get a clear estimate for food, delivery, service and extras.', 'kbap' ); ?></li>
			<li><strong><?php esc_html_e( '4. Serve', 'kbap' ); ?></strong><?php esc_html_e( 'K-BAP prepares, packs, delivers, or serves according to the format.', 'kbap' ); ?></li>
		</ol>
	</div>
</section>

<section class="section" id="quote">
	<div class="container">
		<div class="section-head reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Quote request', 'kbap' ); ?></p>
				<h2 class="t-1"><?php esc_html_e( 'Send the event details.', 'kbap' ); ?></h2>
			</div>
		</div>
		<?php get_template_part( 'template-parts/enquiry-form', null, array( 'topic' => 'catering' ) ); ?>
	</div>
</section>
<?php get_footer(); ?>
