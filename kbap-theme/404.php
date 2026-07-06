<?php
/**
 * 404 template.
 *
 * @package KBAP
 */

get_header();
?>
<section class="hero">
	<div class="container hero-grid">
		<div class="hero-copy">
			<p class="eyebrow"><?php esc_html_e( 'Missing page', 'kbap' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'This table is empty.', 'kbap' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'The page moved, but the menu is still hot. Start with catering, the full menu, or future K-BAP products.', 'kbap' ); ?></p>
			<div class="hero-cta">
				<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/menu/' ) ); ?>"><?php esc_html_e( 'View menu', 'kbap' ); ?></a>
				<a class="btn" href="<?php echo esc_url( home_url( '/catering/' ) ); ?>"><?php esc_html_e( 'Book catering', 'kbap' ); ?></a>
			</div>
		</div>
		<div class="hero-media">
			<img src="<?php echo esc_url( get_theme_file_uri( 'images/event-table.png' ) ); ?>" alt="<?php esc_attr_e( 'Korean catering table with gimbap, japchae and kimchi.', 'kbap' ); ?>">
		</div>
	</div>
</section>
<?php get_footer(); ?>
