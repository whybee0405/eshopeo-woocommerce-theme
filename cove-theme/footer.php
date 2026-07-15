<?php
/**
 * COVE site footer.
 *
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
					<span class="site-logo__mark" aria-hidden="true">O</span>
					<span class="site-logo__wordmark">COVE <span>APPLIANCES</span></span>
				</a>
				<p class="footer-tagline"><?php esc_html_e( 'Appliances made clear. Shop new, demo and graded appliances from trusted brands with transparent condition ratings.', 'cove' ); ?></p>
			</div>

			<div class="footer-col">
				<p class="footer-col__title"><?php esc_html_e( 'Shop', 'cove' ); ?></p>
				<nav class="footer-nav">
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'refrigerators', $cove_shop ) ); ?>"><?php esc_html_e( 'Refrigerators', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'washing-machines', $cove_shop ) ); ?>"><?php esc_html_e( 'Washing Machines', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'dishwashers', $cove_shop ) ); ?>"><?php esc_html_e( 'Dishwashers', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'cooking', $cove_shop ) ); ?>"><?php esc_html_e( 'Cooking', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'tvs', $cove_shop ) ); ?>"><?php esc_html_e( 'TVs', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'air-conditioners', $cove_shop ) ); ?>"><?php esc_html_e( 'Air Conditioners', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'cat', 'small-appliances', $cove_shop ) ); ?>"><?php esc_html_e( 'Small Appliances', 'cove' ); ?></a>
				</nav>
			</div>

			<div class="footer-col">
				<p class="footer-col__title"><?php esc_html_e( 'Clarity', 'cove' ); ?></p>
				<nav class="footer-nav">
					<a href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Grade system', 'cove' ); ?></a>
					<a href="<?php echo esc_url( add_query_arg( 'orderby', 'saving', $cove_shop ) ); ?>"><?php esc_html_e( 'Better priced stock', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>"><?php esc_html_e( 'Buying guides', 'cove' ); ?></a>
				</nav>
			</div>

			<div class="footer-col">
				<p class="footer-col__title"><?php esc_html_e( 'Support', 'cove' ); ?></p>
				<nav class="footer-nav">
					<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My account', 'cove' ); ?></a>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>"><?php esc_html_e( 'Cart', 'cove' ); ?></a>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'cove' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/returns' ) ); ?>"><?php esc_html_e( 'Returns', 'cove' ); ?></a>
				</nav>
			</div>
		</div>

		<div class="footer-bottom">
			<p><?php printf( esc_html__( '&copy; %s COVE. All rights reserved.', 'cove' ), esc_html( date( 'Y' ) ) ); ?></p>
			<p class="t-mono"><?php esc_html_e( 'Appliances made clear.', 'cove' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
