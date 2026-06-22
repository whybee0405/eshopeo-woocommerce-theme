<?php
/**
 * COVE site footer.
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
$cove_shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );
?>

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">

			<div class="footer-brand">
				<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="site-logo__wordmark">COVE</span>
				</a>
				<p class="footer-tagline"><?php esc_html_e( 'New and certified demo appliances for every room. Grade A, B and C stock — honestly described, thoroughly tested.', 'cove' ); ?></p>
			</div>

			<div class="footer-col">
				<p class="footer-col__title"><?php esc_html_e( 'Shop', 'cove' ); ?></p>
				<nav class="footer-nav">
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'kitchen', $cove_shop ) ); ?>"><?php esc_html_e( 'Kitchen', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'laundry', $cove_shop ) ); ?>"><?php esc_html_e( 'Laundry', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'climate', $cove_shop ) ); ?>"><?php esc_html_e( 'Climate', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'floor-care', $cove_shop ) ); ?>"><?php esc_html_e( 'Floor Care', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'personal-care', $cove_shop ) ); ?>"><?php esc_html_e( 'Personal Care', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'orderby', 'saving', $cove_shop ) ); ?>"><?php esc_html_e( 'Deals', 'cove' ); ?></a>
				</nav>
			</div>

			<div class="footer-col">
				<p class="footer-col__title"><?php esc_html_e( 'Info', 'cove' ); ?></p>
				<nav class="footer-nav">
					<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About COVE', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Grade system', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>"><?php esc_html_e( 'The COVE Edit', 'cove' ); ?></a>
				</nav>
			</div>

			<div class="footer-col">
				<p class="footer-col__title"><?php esc_html_e( 'Account', 'cove' ); ?></p>
				<nav class="footer-nav">
					<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My account', 'cove' ); ?></a>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>"><?php esc_html_e( 'Cart', 'cove' ); ?></a>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy policy', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/returns' ) ); ?>"><?php esc_html_e( 'Returns', 'cove' ); ?></a>
				</nav>
			</div>
		</div>

		<div class="footer-bottom">
			<p><?php printf( esc_html__( '&copy; %s COVE. All rights reserved.', 'cove' ), esc_html( date( 'Y' ) ) ); ?></p>
			<p class="t-mono"><?php esc_html_e( 'Home, done right.', 'cove' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
