<?php
/**
 * 404 — Page not found.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main>
	<section class="error-404">
		<div aria-hidden="true" class="error-404__code">404</div>
		<h1 class="t-1"><?php esc_html_e( 'Page not found.', 'cove' ); ?></h1>
		<p class="t-lead" style="max-width:420px;text-align:center">
			<?php esc_html_e( 'The page you are looking for has moved, been removed, or never existed. Let&rsquo;s get you back on track.', 'cove' ); ?>
		</p>
		<a class="btn btn--primary btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Back to homepage', 'cove' ); ?>
		</a>
	</section>
</main>

<?php get_footer(); ?>
