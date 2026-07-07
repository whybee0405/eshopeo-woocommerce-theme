<?php
/**
 * Loyalty Program - served at /loyalty-program
 *
 * @package Glow_KBeauty
 */

get_header();

if ( glow_is_elementor_page() ) {
	echo '<main id="main">';
	while ( have_posts() ) { the_post(); the_content(); }
	echo '</main>';
	get_footer();
	return;
}

$glow_points      = is_user_logged_in() ? glow_loyalty_points_for_user() : 0;
$glow_account_url = glow_wc_active() ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
?>

<main id="main">

	<div class="container">
		<header class="page-hero">
			<p class="eyebrow"><?php esc_html_e( 'Glow Rewards', 'glow-glow' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'Earn points for daily care.', 'glow-glow' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'A simple rewards layer for customers building their Korean skincare routine with Glow.', 'glow-glow' ); ?></p>
		</header>
	</div>

	<section class="section-tight">
		<div class="container">
			<div class="split-panel" data-reveal>
				<div class="panel-a">
					<p class="eyebrow"><?php esc_html_e( 'Earn points', 'glow-glow' ); ?></p>
					<h2 class="t-2"><?php esc_html_e( 'One point for every rand spent.', 'glow-glow' ); ?></h2>
					<p><?php esc_html_e( 'When a WooCommerce order is completed, Glow adds points based on the product subtotal. Your balance lives in My Account under Glow Rewards.', 'glow-glow' ); ?></p>
				</div>
				<div class="panel-b">
					<p class="eyebrow"><?php esc_html_e( 'Redeem rewards', 'glow-glow' ); ?></p>
					<h2 class="t-2"><?php esc_html_e( 'Turn 250 points into R25 off.', 'glow-glow' ); ?></h2>
					<p><?php esc_html_e( 'Logged-in customers can create a single-use reward coupon once enough points are available.', 'glow-glow' ); ?></p>
					<p class="lead"><?php echo esc_html( sprintf( __( 'Current balance: %d points', 'glow-glow' ), $glow_points ) ); ?></p>
					<a class="btn btn-solid" href="<?php echo esc_url( $glow_account_url ); ?>"><?php esc_html_e( 'Open My Account', 'glow-glow' ); ?></a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
