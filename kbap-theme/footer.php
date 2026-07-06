<?php
/**
 * K-BAP footer.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;
?>
</main>

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php kbap_logo(); ?></a>
				<p><?php esc_html_e( 'Authentic Korean catering for South African events today, with K-BAP Kimchi, meal kits and market products ready for tomorrow.', 'kbap' ); ?></p>
			</div>
			<div>
				<p class="footer-title"><?php esc_html_e( 'Eat', 'kbap' ); ?></p>
				<nav class="footer-nav">
					<a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>"><?php esc_html_e( 'Menu', 'kbap' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/catering/' ) ); ?>"><?php esc_html_e( 'Catering', 'kbap' ); ?></a>
					<a href="<?php echo esc_url( kbap_wc_active() && function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Shop', 'kbap' ); ?></a>
				</nav>
			</div>
			<div>
				<p class="footer-title"><?php esc_html_e( 'Brand', 'kbap' ); ?></p>
				<nav class="footer-nav">
					<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'kbap' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'FAQ', 'kbap' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'kbap' ); ?></a>
				</nav>
			</div>
			<div>
				<p class="footer-title"><?php esc_html_e( 'Johannesburg', 'kbap' ); ?></p>
				<nav class="footer-nav">
					<a href="mailto:hello@kbap.co.za">hello@kbap.co.za</a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Request a quote', 'kbap' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'kbap' ); ?></a>
				</nav>
			</div>
		</div>
		<div class="footer-bottom">
			<p><?php printf( esc_html__( '&copy; %s K-BAP. All rights reserved.', 'kbap' ), esc_html( date( 'Y' ) ) ); ?></p>
			<p><?php esc_html_e( 'Korean food, made for here.', 'kbap' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
