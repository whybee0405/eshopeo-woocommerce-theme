<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$profile     = partsmall_site_profile();
$brands      = partsmall_private_brands();
$home_anchor = trailingslashit( home_url( '/' ) );
unset( $brands['oem-genuine'] );
?>
</main>
<footer class="site-footer" role="contentinfo">
	<div class="container site-footer__inner">
		<div class="footer-grid">
			<div class="footer-brand">
				<img src="<?php echo esc_url( get_theme_file_uri( 'images/logo.svg' ) ); ?>" alt="<?php esc_attr_e( 'Parts-Mall Africa', 'parts-mall' ); ?>">
				<p><?php echo esc_html( $profile['hero_copy'] ); ?></p>
				<div class="footer-socials">
					<?php foreach ( $profile['socials'] as $social ) : ?>
						<a class="footer-social" href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social['label'] ); ?>"><?php echo esc_html( $social['label'] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer-col">
				<h2 class="footer-col__title"><?php esc_html_e( 'Explore', 'parts-mall' ); ?></h2>
				<div class="footer-links">
					<a href="<?php echo esc_url( $home_anchor . '#global-network' ); ?>"><?php esc_html_e( 'Global network', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( $home_anchor . '#brands' ); ?>"><?php esc_html_e( 'Private brands', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( $home_anchor . '#category-authority' ); ?>"><?php esc_html_e( 'Spare categories', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( $home_anchor . '#insights' ); ?>"><?php esc_html_e( 'Insights', 'parts-mall' ); ?></a>
				</div>
			</div>

			<div class="footer-col">
				<h2 class="footer-col__title"><?php esc_html_e( 'Company', 'parts-mall' ); ?></h2>
				<div class="footer-links">
					<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/become-an-agent' ) ); ?>"><?php esc_html_e( 'Become an agent', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'parts-mall' ); ?></a>
				</div>
			</div>

			<div class="footer-col">
				<h2 class="footer-col__title"><?php esc_html_e( 'Network', 'parts-mall' ); ?></h2>
				<div class="footer-links">
					<a href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Branch finder', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/find-a-branch#pan-africa' ) ); ?>"><?php esc_html_e( 'Pan-African reach', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( $home_anchor . '#reviews' ); ?>"><?php esc_html_e( 'Customer trust', 'parts-mall' ); ?></a>
					<a href="<?php echo esc_url( partsmall_head_office_map_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Head office directions', 'parts-mall' ); ?></a>
				</div>
			</div>

			<div class="footer-col">
				<h2 class="footer-col__title"><?php esc_html_e( 'Head Office', 'parts-mall' ); ?></h2>
				<div class="footer-links">
					<a href="mailto:<?php echo esc_attr( $profile['head_office_email'] ); ?>"><?php echo esc_html( $profile['head_office_email'] ); ?></a>
					<?php foreach ( array_slice( $profile['head_office_address'], 0, 4 ) as $line ) : ?>
						<span><?php echo esc_html( $line ); ?></span>
					<?php endforeach; ?>
					<span><?php esc_html_e( 'Mon-Fri, 08:00-17:00 SAST', 'parts-mall' ); ?></span>
				</div>
			</div>
		</div>

		<div class="footer-private-brands" aria-label="<?php esc_attr_e( 'Private brands', 'parts-mall' ); ?>">
			<?php foreach ( $brands as $brand ) : ?>
				<span class="badge badge--paper"><?php echo esc_html( $brand['label'] ); ?></span>
			<?php endforeach; ?>
		</div>

		<div class="footer-bottom">
			<div><?php echo esc_html( gmdate( 'Y' ) ); ?> &copy; <?php esc_html_e( 'Parts-Mall Africa. All rights reserved.', 'parts-mall' ); ?></div>
			<div><?php esc_html_e( 'Built for branch-led enquiries, wholesale growth, and corporate aftermarket authority.', 'parts-mall' ); ?></div>
		</div>
	</div>
	<div class="footer-wordmark" aria-hidden="true">Parts-Mall</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
