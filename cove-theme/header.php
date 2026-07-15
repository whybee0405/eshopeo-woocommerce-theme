<?php
/**
 * COVE site header.
 *
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

<?php
$cove_shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );
$shop_categories = array();
if ( taxonomy_exists( 'product_cat' ) ) {
	$shop_terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );
	if ( ! is_wp_error( $shop_terms ) ) {
		foreach ( $shop_terms as $term ) {
			$shop_categories[] = array(
				'label' => $term->name,
				'url'   => add_query_arg( 'cat', $term->slug, $cove_shop ),
			);
		}
	}
}
if ( empty( $shop_categories ) && function_exists( 'cove_categories' ) ) {
	foreach ( cove_categories() as $slug => $cat ) {
		$shop_categories[] = array(
			'label' => $cat['label'],
			'url'   => add_query_arg( 'cat', $slug, $cove_shop ),
		);
	}
}
$nav_items = array(
	array(
		'label' => __( 'Shop', 'cove' ),
		'url'   => $cove_shop,
		'desc'  => __( 'Browse every available category from the current COVE catalogue.', 'cove' ),
		'items' => $shop_categories,
	),
	array(
		'label' => __( 'Promotions', 'cove' ),
		'url'   => home_url( '/promotions' ),
		'desc'  => __( 'Current COVE offers and value-led stock highlights.', 'cove' ),
		'items' => array(),
	),
	array(
		'label' => __( 'Contact Us', 'cove' ),
		'url'   => home_url( '/contact' ),
		'desc'  => __( 'Speak to COVE before or after checkout.', 'cove' ),
		'items' => array(),
	),
	array(
		'label' => __( 'About Us', 'cove' ),
		'url'   => home_url( '/about' ),
		'desc'  => __( 'Why COVE exists and how we grade appliances clearly.', 'cove' ),
		'items' => array(),
	),
	array(
		'label' => __( 'Buying Guide', 'cove' ),
		'url'   => home_url( '/buying-guide' ),
		'desc'  => __( 'How to choose grade, category, warranty, and delivery fit.', 'cove' ),
		'items' => array(),
	),
	array(
		'label' => __( 'Rewards', 'cove' ),
		'url'   => home_url( '/rewards' ),
		'desc'  => __( 'COVE customer rewards, early access, and future perks.', 'cove' ),
		'items' => array(),
	),
);
?>

<div class="notice-bar" role="region" aria-label="<?php esc_attr_e( 'Store notices', 'cove' ); ?>">
	<div class="notice-bar__track" aria-hidden="true">
		<?php
		$notices = array(
			sprintf( '<span class="notice-bar__item">%s</span><span class="notice-bar__sep">|</span>', esc_html__( 'Premium appliances, clearly graded', 'cove' ) ),
			sprintf( '<span class="notice-bar__item">%s <a href="%s">%s</a></span><span class="notice-bar__sep">|</span>', esc_html__( 'New, demo and graded stock', 'cove' ), esc_url( home_url( '/grades' ) ), esc_html__( 'understand grades', 'cove' ) ),
			sprintf( '<span class="notice-bar__item">%s</span><span class="notice-bar__sep">|</span>', esc_html__( 'Inspected before dispatch', 'cove' ) ),
			sprintf( '<span class="notice-bar__item">%s</span><span class="notice-bar__sep">|</span>', esc_html__( 'Simple nationwide delivery', 'cove' ) ),
		);
		$track = implode( '', $notices );
		echo $track . $track; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
</div>

<header class="site-header" data-header>
	<div class="container header-inner">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'COVE Appliances home', 'cove' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="site-logo__mark" aria-hidden="true">O</span>
				<span class="site-logo__wordmark">COVE <span>APPLIANCES</span></span>
			<?php endif; ?>
		</a>

		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'cove' ); ?>">
			<?php foreach ( $nav_items as $item ) : ?>
				<div class="primary-nav__item">
					<a class="primary-nav__trigger" href="<?php echo esc_url( $item['url'] ); ?>" aria-haspopup="true">
						<?php echo esc_html( $item['label'] ); ?>
						<?php if ( ! empty( $item['items'] ) ) : ?>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
						<?php endif; ?>
					</a>
					<?php if ( ! empty( $item['items'] ) ) : ?>
						<div class="primary-nav__dropdown">
							<p class="primary-nav__dropdown-title"><?php echo esc_html( $item['label'] ); ?></p>
							<p class="primary-nav__dropdown-desc"><?php echo esc_html( $item['desc'] ); ?></p>
							<div class="primary-nav__dropdown-links">
								<?php foreach ( $item['items'] as $sub_item ) : ?>
									<a href="<?php echo esc_url( $sub_item['url'] ); ?>"><?php echo esc_html( $sub_item['label'] ); ?></a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</nav>

		<div class="header-actions">
			<button class="header-icon-btn" type="button" data-search-toggle aria-expanded="false" aria-controls="site-search-overlay" aria-label="<?php esc_attr_e( 'Search appliances', 'cove' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			</button>

			<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
				<a class="header-icon-btn" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'cove' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
					<span class="cart-count" data-cart-count aria-live="polite">
						<?php echo function_exists( 'WC' ) && WC()->cart ? absint( WC()->cart->get_cart_contents_count() ) : ''; ?>
					</span>
				</a>
			<?php endif; ?>

			<button class="menu-toggle" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'cove' ); ?>">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
			</button>
		</div>
	</div>
</header>

<div class="search-overlay" id="site-search-overlay" data-search-overlay aria-hidden="true">
	<div class="search-overlay__panel" role="dialog" aria-modal="true" aria-labelledby="site-search-title">
		<div class="search-overlay__head">
			<div>
				<p class="cove-kicker"><?php esc_html_e( 'Find your appliance', 'cove' ); ?></p>
				<h2 id="site-search-title"><?php esc_html_e( 'Search COVE stock', 'cove' ); ?></h2>
			</div>
			<button class="header-icon-btn" type="button" data-search-close aria-label="<?php esc_attr_e( 'Close search', 'cove' ); ?>">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
		</div>
		<form role="search" method="get" class="search-overlay__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="sr-only" for="site-search-input"><?php esc_html_e( 'Search appliances', 'cove' ); ?></label>
			<input class="search-overlay__input" id="site-search-input" data-search-input type="search" name="s" placeholder="<?php esc_attr_e( 'Search fridges, washing machines, A Grade Bosch...', 'cove' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off">
			<input type="hidden" name="post_type" value="product">
			<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Search', 'cove' ); ?></button>
		</form>
		<div class="search-quick-links" aria-label="<?php esc_attr_e( 'Popular searches', 'cove' ); ?>">
			<a href="<?php echo esc_url( add_query_arg( array( 's' => 'A Grade fridge', 'post_type' => 'product' ), home_url( '/' ) ) ); ?>"><?php esc_html_e( 'A Grade fridge', 'cove' ); ?></a>
			<a href="<?php echo esc_url( add_query_arg( array( 's' => 'washing machine', 'post_type' => 'product' ), home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Washing machine', 'cove' ); ?></a>
			<a href="<?php echo esc_url( add_query_arg( array( 's' => 'Bosch', 'post_type' => 'product' ), home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Bosch', 'cove' ); ?></a>
			<a href="<?php echo esc_url( add_query_arg( array( 's' => 'best value', 'post_type' => 'product' ), home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Best value', 'cove' ); ?></a>
		</div>
	</div>
</div>

<div class="mobile-menu" id="mobile-menu" data-mobile-menu aria-hidden="true">
	<div class="mobile-menu__head">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="site-logo__mark" aria-hidden="true">O</span>
			<span class="site-logo__wordmark">COVE <span>APPLIANCES</span></span>
		</a>
		<button class="header-icon-btn" data-menu-close aria-label="<?php esc_attr_e( 'Close menu', 'cove' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'cove' ); ?>">
		<?php foreach ( $nav_items as $item ) : ?>
			<div class="mobile-nav__group">
				<a href="<?php echo esc_url( $item['url'] ); ?>">
					<?php echo esc_html( $item['label'] ); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
				<?php if ( ! empty( $item['items'] ) ) : ?>
					<div class="mobile-nav__submenu">
						<?php foreach ( $item['items'] as $sub_item ) : ?>
							<a href="<?php echo esc_url( $sub_item['url'] ); ?>"><?php echo esc_html( $sub_item['label'] ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<span><a href="<?php echo esc_url( home_url( '/grades' ) ); ?>"><?php esc_html_e( 'Understand Grades', 'cove' ); ?><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg></a></span>
	</nav>
</div>

<div class="toast" data-toast role="status" aria-live="polite">
	<span data-toast-message></span>
</div>
