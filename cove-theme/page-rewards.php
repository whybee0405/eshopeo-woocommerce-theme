<?php
/**
 * Rewards page.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main">
	<section class="section cove-static-hero">
		<div class="container cove-static-hero__inner">
			<p class="cove-kicker"><?php esc_html_e( 'COVE Rewards', 'cove' ); ?></p>
			<h1 class="t-1"><?php esc_html_e( 'Rewards are coming soon.', 'cove' ); ?></h1>
			<p class="t-lead"><?php esc_html_e( 'Coming soon: early access to premium demo stock, member-only value drops, and service perks for returning COVE customers.', 'cove' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Ask about rewards', 'cove' ); ?></a>
		</div>
	</section>
</main>

<?php get_footer(); ?>
