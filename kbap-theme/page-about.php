<?php
/**
 * Template Name: About
 *
 * @package KBAP
 */

get_header();
?>
<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'About K-BAP', 'kbap' ); ?></p>
				<h1 class="t-1"><?php esc_html_e( 'Authentic Korean food, made for South African events.', 'kbap' ); ?></h1>
			</div>
			<p class="lead"><?php esc_html_e( 'K-BAP sits between home cooking, cultural table, and professional catering. The food is trusted by Koreans who know the reference point and by non-Korean guests discovering it properly.', 'kbap' ); ?></p>
		</div>
		<div class="trust-grid">
			<div class="trust-item reveal"><p class="eyebrow"><?php esc_html_e( 'Proof', 'kbap' ); ?></p><h3><?php esc_html_e( 'Institutional trust', 'kbap' ); ?></h3><p class="muted"><?php esc_html_e( 'K-BAP has catered events connected to the Korean Embassy of South Africa, Korean Association of South Africa, and Korean Cultural Centre.', 'kbap' ); ?></p></div>
			<div class="trust-item reveal"><p class="eyebrow"><?php esc_html_e( 'Festival', 'kbap' ); ?></p><h3><?php esc_html_e( 'KFFF participant', 'kbap' ); ?></h3><p class="muted"><?php esc_html_e( 'The brand has participated in Korean Food Film Festival activity and unnamed private events that require discretion.', 'kbap' ); ?></p></div>
			<div class="trust-item reveal"><p class="eyebrow"><?php esc_html_e( 'Future', 'kbap' ); ?></p><h3><?php esc_html_e( 'From catering to shelves', 'kbap' ); ?></h3><p class="muted"><?php esc_html_e( 'K-BAP Kimchi is already loved. The next stage is local markets, branded jars, meal kits, and online products.', 'kbap' ); ?></p></div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
