<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="page-shell">
	<div class="container editorial">
		<?php while ( have_posts() ) : the_post(); ?>
			<header class="page-hero" data-reveal>
				<p class="eyebrow"><?php esc_html_e( 'Page', 'parts-mall' ); ?></p>
				<h1 class="t-1"><?php the_title(); ?></h1>
			</header>
			<div class="editorial__content" data-reveal>
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>
