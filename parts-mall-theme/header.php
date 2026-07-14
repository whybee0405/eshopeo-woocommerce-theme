<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'partsmall_default_nav' ) ) {
	function partsmall_default_nav() {
		$home_anchor = trailingslashit( home_url( '/' ) );
		$links       = array(
			array( 'url' => home_url( '/' ), 'label' => __( 'Home', 'parts-mall' ) ),
			array( 'url' => $home_anchor . '#global-network', 'label' => __( 'Global Network', 'parts-mall' ) ),
			array( 'url' => $home_anchor . '#brands', 'label' => __( 'Brands', 'parts-mall' ) ),
			array( 'url' => home_url( '/find-a-branch' ), 'label' => __( 'Branch Finder', 'parts-mall' ) ),
			array( 'url' => home_url( '/become-an-agent' ), 'label' => __( 'Wholesale', 'parts-mall' ) ),
			array( 'url' => $home_anchor . '#insights', 'label' => __( 'Insights', 'parts-mall' ) ),
			array( 'url' => home_url( '/about' ), 'label' => __( 'About', 'parts-mall' ) ),
			array( 'url' => home_url( '/contact' ), 'label' => __( 'Contact', 'parts-mall' ) ),
		);

		echo '<ul>';
		foreach ( $links as $link ) {
			printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( $link['url'] ), esc_html( $link['label'] ) );
		}
		echo '</ul>';
	}
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'parts-mall' ); ?></a>
<header class="site-header" data-site-header>
	<div class="container site-header__inner">
		<div class="site-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'Parts-Mall home', 'parts-mall' ); ?>">
				<img src="<?php echo esc_url( get_theme_file_uri( 'images/logo.svg' ) ); ?>" alt="<?php esc_attr_e( 'Parts-Mall Africa', 'parts-mall' ); ?>">
			</a>
		</div>

		<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'parts-mall' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'partsmall_default_nav',
				)
			);
			?>
		</nav>

		<div class="header-utils">
			<a class="branch-shortcut" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Find a branch', 'parts-mall' ); ?></a>
			<a class="btn btn--signal btn--sm header-cta" href="<?php echo esc_url( home_url( '/become-an-agent' ) ); ?>"><?php esc_html_e( 'Wholesale and franchise', 'parts-mall' ); ?></a>
			<button type="button" class="icon-btn nav-toggle" data-nav-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'parts-mall' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
			</button>
		</div>
	</div>
</header>

<div id="mobile-menu" class="mobile-menu" data-mobile-menu>
	<div class="mobile-menu__head">
		<img src="<?php echo esc_url( get_theme_file_uri( 'images/logo.svg' ) ); ?>" alt="<?php esc_attr_e( 'Parts-Mall Africa', 'parts-mall' ); ?>">
		<button type="button" class="icon-btn" data-nav-close aria-label="<?php esc_attr_e( 'Close menu', 'parts-mall' ); ?>">&times;</button>
	</div>
	<nav class="mobile-menu__nav" aria-label="<?php esc_attr_e( 'Mobile', 'parts-mall' ); ?>">
		<?php partsmall_default_nav(); ?>
	</nav>
	<div class="mobile-menu__footer">
		<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Find your nearest branch', 'parts-mall' ); ?></a>
		<p class="mobile-menu__meta"><?php esc_html_e( 'Branch-led supply, wholesale growth, and corporate aftermarket authority across South Africa and Africa.', 'parts-mall' ); ?></p>
	</div>
</div>
<main id="main" class="site-main">
