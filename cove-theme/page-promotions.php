<?php
/**
 * Promotions page.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );
?>

<main id="main">
	<section class="section cove-static-hero">
		<div class="container cove-static-hero__inner">
			<p class="cove-kicker"><?php esc_html_e( 'COVE Promotions', 'cove' ); ?></p>
			<h1 class="t-1"><?php esc_html_e( 'Best value drops, clearly graded.', 'cove' ); ?></h1>
			<p class="t-lead"><?php esc_html_e( 'This page will feature current offers, demo-stock highlights, seasonal value edits, and limited-time appliance promotions.', 'cove' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( add_query_arg( 'orderby', 'saving', $shop_url ) ); ?>"><?php esc_html_e( 'Browse best value stock', 'cove' ); ?></a>
		</div>
	</section>
</main>

<?php get_footer(); ?>
