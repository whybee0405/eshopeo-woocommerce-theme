<?php
/**
 * Buying guide page.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main">
	<section class="section cove-static-hero">
		<div class="container cove-static-hero__inner">
			<p class="cove-kicker"><?php esc_html_e( 'COVE Buying Guide', 'cove' ); ?></p>
			<h1 class="t-1"><?php esc_html_e( 'Choose the right grade, size and delivery fit.', 'cove' ); ?></h1>
			<p class="t-lead"><?php esc_html_e( 'This guide will help customers compare New, A, B and C Grade appliances, understand visible marks, check warranty context, and choose appliances with confidence.', 'cove' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Understand grades', 'cove' ); ?></a>
		</div>
	</section>
</main>

<?php get_footer(); ?>
