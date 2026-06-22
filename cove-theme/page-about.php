<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * About COVE page.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<!-- Page hero -->
<section class="page-hero">
	<div class="container">
		<span class="eyebrow eyebrow--amber"><?php esc_html_e( 'Our story', 'cove' ); ?></span>
		<h1 class="t-1"><?php esc_html_e( 'Home, done right.', 'cove' ); ?></h1>
		<p class="t-lead"><?php esc_html_e( 'COVE was built on a simple idea: excellent home appliances should not require a retail markup. We source certified demo and b-stock units directly, inspect every one, and pass the savings to you.', 'cove' ); ?></p>
	</div>
</section>

<!-- Prose body -->
<section class="section">
	<div class="container">
		<div class="prose" data-reveal>

			<h2 class="t-2"><?php esc_html_e( 'Why COVE?', 'cove' ); ?></h2>
			<p><?php esc_html_e( 'South African households spend more on home appliances than almost any other discretionary category &mdash; and that spend has been rising steadily. COVE exists because we believe the smartest move is not to buy cheaper junk; it is to buy the same quality product for less. That is what b-stock makes possible.', 'cove' ); ?></p>
			<p><?php esc_html_e( 'We started by working with a handful of appliance brands to offload their certified demo stock. Brands needed a home for units that had toured showrooms or been used at expos. We needed inventory. Customers needed a trustworthy source. The fit was obvious.', 'cove' ); ?></p>

			<h2 class="t-2"><?php esc_html_e( 'The b-stock advantage', 'cove' ); ?></h2>
			<p><?php esc_html_e( 'B-stock is not second-hand in the flea-market sense. It is manufacturer-adjacent inventory: units that left the factory in perfect condition but did not complete a standard retail journey. A fridge that stood on a showroom floor for three months. A washing machine used as a display model at a trade fair. A dishwasher returned unopened after a kitchen renovation was cancelled.', 'cove' ); ?></p>
			<p><?php esc_html_e( 'Because these units bypassed the full retail chain, the margin savings are real &mdash; 30% to 65% depending on grade and age. We pass that saving to you directly, with full transparency about what you are buying.', 'cove' ); ?></p>

			<h2 class="t-2"><?php esc_html_e( 'Our promise', 'cove' ); ?></h2>
			<p><?php esc_html_e( 'Every unit listed on COVE has been inspected, photographed and graded by our in-house team. We grade on a three-point scale &mdash; A, B and C &mdash; that tells you exactly what to expect cosmetically and functionally. Nothing is listed as Grade A that has visible wear; nothing is listed as Grade C without clear photographs of every defect.', 'cove' ); ?></p>
			<p><?php esc_html_e( 'Every unit carries a 90-day COVE warranty and qualifies for 30-day returns. We stand behind the stock we sell because our reputation depends on it. That is the deal &mdash; honest grading, real savings, full accountability.', 'cove' ); ?></p>

			<div style="margin-top:var(--s-7)">
				<div class="cluster">
					<a class="btn btn--primary" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>">
						<?php esc_html_e( 'Shop appliances', 'cove' ); ?>
					</a>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/grades' ) ); ?>">
						<?php esc_html_e( 'Understand the grades', 'cove' ); ?>
					</a>
				</div>
			</div>

		</div><!-- .prose -->
	</div>
</section>

<?php get_footer(); ?>
