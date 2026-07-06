<?php
/**
 * Template Name: Menu
 *
 * @package KBAP
 */

get_header();
$sections = kbap_menu_sections();
?>
<section class="section section--cream">
	<div class="container">
		<p class="eyebrow"><?php esc_html_e( 'SEO-friendly menu', 'kbap' ); ?></p>
		<h1 class="t-1"><?php esc_html_e( 'K-BAP Korean catering menu.', 'kbap' ); ?></h1>
		<p class="lead"><?php esc_html_e( 'A living menu for catering, markets, and future online ordering. Final pricing depends on guest count, service format, distance, and menu mix.', 'kbap' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container menu-band">
		<nav class="menu-nav" data-menu-nav aria-label="<?php esc_attr_e( 'Menu categories', 'kbap' ); ?>">
			<?php foreach ( $sections as $slug => $section ) : ?>
				<a href="#<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $section['title'] ); ?></a>
			<?php endforeach; ?>
		</nav>
		<div>
			<?php foreach ( $sections as $slug => $section ) : ?>
				<section class="menu-section reveal" id="<?php echo esc_attr( $slug ); ?>">
					<p class="eyebrow"><?php echo esc_html( $section['kicker'] ); ?></p>
					<h2 class="t-2"><?php echo esc_html( $section['title'] ); ?></h2>
					<p class="muted"><?php echo esc_html( $section['intro'] ); ?></p>
					<?php foreach ( $section['items'] as $item ) : ?>
						<article class="menu-item">
							<div>
								<h3><?php echo esc_html( $item['name'] ); ?></h3>
								<p><?php echo esc_html( $item['desc'] ); ?></p>
								<div class="dish-meta">
									<?php foreach ( $item['tags'] as $tag ) : ?>
										<span><?php echo esc_html( $tag ); ?></span>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="menu-item__price"><?php echo esc_html( $item['price'] ); ?></div>
						</article>
					<?php endforeach; ?>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
