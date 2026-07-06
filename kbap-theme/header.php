<?php
/**
 * K-BAP header.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'kbap' ); ?></a>

<div class="notice">
	<div class="container notice__inner">
		<span><?php esc_html_e( 'Korean catering from Johannesburg, built for South African tables.', 'kbap' ); ?></span>
		<span><strong><?php esc_html_e( 'Trusted for embassy, association, cultural centre and festival events.', 'kbap' ); ?></strong></span>
	</div>
</div>

<header class="site-header" data-header>
	<div class="container header-inner">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'K-BAP home', 'kbap' ); ?>">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				kbap_logo();
			}
			?>
		</a>

		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'kbap' ); ?>">
			<?php foreach ( kbap_nav_items() as $item ) : ?>
				<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
		</nav>

		<div class="header-actions">
			<a class="header-pill header-pill--hide-mobile" href="<?php echo esc_url( home_url( '/catering/' ) ); ?>"><?php esc_html_e( 'Book catering', 'kbap' ); ?></a>
			<?php if ( kbap_wc_active() && function_exists( 'wc_get_cart_url' ) ) : ?>
				<a class="header-pill" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'kbap' ); ?>">
					<?php esc_html_e( 'Cart', 'kbap' ); ?>
					<span class="cart-count" data-cart-count aria-live="polite"><?php echo function_exists( 'WC' ) && WC()->cart ? absint( WC()->cart->get_cart_contents_count() ) : 0; ?></span>
				</a>
			<?php endif; ?>
			<button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'kbap' ); ?>">
				<span aria-hidden="true">Menu</span>
			</button>
		</div>
	</div>
</header>

<div class="mobile-menu" id="mobile-menu" data-mobile-menu aria-hidden="true">
	<div class="mobile-menu__top">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php kbap_logo(); ?></a>
		<button class="btn btn--primary" type="button" data-menu-close><?php esc_html_e( 'Close', 'kbap' ); ?></button>
	</div>
	<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'kbap' ); ?>">
		<?php foreach ( kbap_nav_items() as $item ) : ?>
			<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?><span aria-hidden="true">+</span></a>
		<?php endforeach; ?>
	</nav>
</div>

<main id="content">
