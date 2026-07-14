<?php
/**
 * Template Name: About
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$profile   = partsmall_site_profile();
$timeline  = partsmall_group_timeline();
$locations = partsmall_global_locations();
$faqs      = partsmall_faq_items();
$facts     = array_slice( $profile['corporate_facts'], 0, 4 );
?>

<div class="page-shell">
	<div class="container about-layout">
		<header class="page-hero" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'About Parts-Mall Africa', 'parts-mall' ); ?></p>
			<h1 class="t-1"><?php the_title(); ?></h1>
			<p class="lead"><?php echo esc_html( $profile['hero_copy'] ); ?></p>
		</header>

		<section class="surface about-facts-strip" aria-label="<?php esc_attr_e( 'Corporate facts', 'parts-mall' ); ?>" data-reveal>
			<div class="about-facts-grid">
				<?php foreach ( $facts as $fact ) : ?>
					<div class="about-fact">
						<strong><?php echo esc_html( $fact['value'] ); ?></strong>
						<span><?php echo esc_html( $fact['label'] ); ?></span>
						<small><?php echo esc_html( $fact['note'] ); ?></small>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<div class="about-grid">
			<div class="editorial__content" data-reveal>
				<h2 class="t-2"><?php esc_html_e( 'Global group, local execution', 'parts-mall' ); ?></h2>
				<p><?php esc_html_e( 'Parts-Mall Africa forms part of a broader automotive aftermarket group with established global buyer relationships, specialised logistics capability, and a long-running focus on parts distribution.', 'parts-mall' ); ?></p>
				<p><?php esc_html_e( 'For customers in South Africa, that means more than product range alone. It means supply depth, faster routing, trusted private brands, and a real branch network you can contact when a vehicle needs attention now.', 'parts-mall' ); ?></p>
				<h2 class="t-2"><?php esc_html_e( 'What the group story gives the local market', 'parts-mall' ); ?></h2>
				<ul>
					<li><?php esc_html_e( 'A stronger supply and logistics backbone behind local branches', 'parts-mall' ); ?></li>
					<li><?php esc_html_e( 'Private-brand confidence supported by quality and warranty positioning', 'parts-mall' ); ?></li>
					<li><?php esc_html_e( 'Greater credibility for wholesale, workshop, fleet, and franchise growth conversations', 'parts-mall' ); ?></li>
				</ul>
			</div>

			<div class="form-card about-network-card" data-reveal>
				<img src="<?php echo esc_url( get_theme_file_uri( 'images/generated-concepts/parts-mall-global-network-map.png' ) ); ?>" alt="<?php esc_attr_e( 'Parts-Mall international network concept', 'parts-mall' ); ?>" loading="lazy" decoding="async">
				<div class="details-stack about-network-card__list">
					<?php foreach ( array_slice( $locations, 0, 4 ) as $location ) : ?>
						<div class="network-node">
							<strong><?php echo esc_html( $location['label'] ); ?></strong>
							<span><?php echo esc_html( $location['place'] ); ?></span>
							<small><?php echo esc_html( $location['type'] ); ?></small>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="timeline-grid timeline-grid--light" data-reveal>
			<?php foreach ( $timeline as $item ) : ?>
				<div class="timeline-item">
					<strong><?php echo esc_html( $item['year'] ); ?></strong>
					<p><?php echo esc_html( $item['event'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="details-stack">
			<?php foreach ( $faqs as $faq ) : ?>
				<details class="accordion-card" data-reveal>
					<summary><?php echo esc_html( $faq['q'] ); ?></summary>
					<div class="accordion-card__content"><p><?php echo esc_html( $faq['a'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>

		<section class="surface contact-band" data-reveal>
			<div class="contact-band__layout">
				<div>
					<h2 class="t-2"><?php esc_html_e( 'Ready to work with Parts-Mall Africa?', 'parts-mall' ); ?></h2>
					<p class="muted"><?php esc_html_e( 'Find your nearest branch for immediate support, or contact head office for wholesale, campaigns, and routed commercial enquiries.', 'parts-mall' ); ?></p>
				</div>
				<div class="contact-band__actions">
					<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Find a branch', 'parts-mall' ); ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact head office', 'parts-mall' ); ?></a>
				</div>
			</div>
		</section>
	</div>
</div>

<?php get_footer(); ?>
