<?php
/**
 * COVE site header.
 * @package COVE
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

<!-- Notice bar -->
<div class="notice-bar" role="region" aria-label="<?php esc_attr_e( 'Store notices', 'cove' ); ?>">
	<div class="notice-bar__track" aria-hidden="true">
		<?php
		$notices = array(
			sprintf( '<span class="notice-bar__item">%s</span><span class="notice-bar__sep">·</span>', esc_html__( 'Free shipping on orders over R800', 'cove' ) ),
			sprintf( '<span class="notice-bar__item">%s <a href="%s">%s</a></span><span class="notice-bar__sep">·</span>', esc_html__( 'Grade A from R299 —', 'cove' ), esc_url( home_url( '/grades' ) ), esc_html__( 'what\'s the catch? Nothing.', 'cove' ) ),
			sprintf( '<span class="notice-bar__item">%s</span><span class="notice-bar__sep">·</span>', esc_html__( '30-day returns on all stock', 'cove' ) ),
			sprintf( '<span class="notice-bar__item">%s</span><span class="notice-bar__sep">·</span>', esc_html__( '90-day warranty on all Grade stock', 'cove' ) ),
		);
		// Duplicate for seamless loop.
		$track = implode( '', $notices );
		echo $track . $track; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
</div>

<!-- Site header -->
<header class="site-header" data-header>
	<div class="container header-inner">

		<!-- Logo -->
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'COVE — Home', 'cove' ); ?>">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<span class="site-logo__wordmark">COVE</span>
			<?php endif; ?>
		</a>

		<!-- Primary nav -->
		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'cove' ); ?>">
			<?php
			$cove_shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );
			$nav_items = array(
				array( 'label' => __( 'Kitchen', 'cove' ),      'url' => add_query_arg( 'cat', 'kitchen', $cove_shop ) ),
				array( 'label' => __( 'Laundry', 'cove' ),      'url' => add_query_arg( 'cat', 'laundry', $cove_shop ) ),
				array( 'label' => __( 'Climate', 'cove' ),      'url' => add_query_arg( 'cat', 'climate', $cove_shop ) ),
				array( 'label' => __( 'Floor Care', 'cove' ),   'url' => add_query_arg( 'cat', 'floor-care', $cove_shop ) ),
				array( 'label' => __( 'Personal Care', 'cove' ),'url' => add_query_arg( 'cat', 'personal-care', $cove_shop ) ),
				array( 'label' => __( 'Deals', 'cove' ),        'url' => add_query_arg( 'orderby', 'saving', $cove_shop ), 'class' => 'nav-deals' ),
			);
			foreach ( $nav_items as $item ) :
				$class = isset( $item['class'] ) ? ' class="' . esc_attr( $item['class'] ) . '"' : '';
				?>
				<span<?php echo $class; // phpcs:ignore ?>>
					<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				</span>
			<?php endforeach; ?>
		</nav>

		<!-- Actions -->
		<div class="header-actions">

			<!-- Search -->
			<a class="header-icon-btn" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="<?php esc_attr_e( 'Search', 'cove' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			</a>

			<!-- Cart -->
			<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
				<a class="header-icon-btn" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'cove' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
					<span class="cart-count" data-cart-count aria-live="polite">
						<?php echo function_exists( 'WC' ) ? absint( WC()->cart->get_cart_contents_count() ) : ''; ?>
					</span>
				</a>
			<?php endif; ?>

			<!-- Mobile toggle -->
			<button class="menu-toggle" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'cove' ); ?>">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
			</button>
		</div>
	</div>
</header>

<!-- Mobile menu -->
<div class="mobile-menu" id="mobile-menu" data-mobile-menu aria-hidden="true">
	<div class="mobile-menu__head">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="site-logo__wordmark">COVE</span>
		</a>
		<button class="header-icon-btn" data-menu-close aria-label="<?php esc_attr_e( 'Close menu', 'cove' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'cove' ); ?>">
		<?php
		foreach ( $nav_items as $item ) :
			$class = isset( $item['class'] ) ? ' class="' . esc_attr( $item['class'] ) . '"' : '';
			?>
			<span<?php echo $class; // phpcs:ignore ?>>
				<a href="<?php echo esc_url( $item['url'] ); ?>">
					<?php echo esc_html( $item['label'] ); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
			</span>
		<?php endforeach; ?>
		<span><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'cove' ); ?><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg></a></span>
		<span><a href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Grades explained', 'cove' ); ?><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg></a></span>
	</nav>
</div>

<!-- Toast -->
<div class="toast" data-toast role="status" aria-live="polite">
	<span data-toast-message></span>
</div>
