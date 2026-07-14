<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="page-shell">
	<div class="container editorial">
		<header class="page-hero" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Insights', 'parts-mall' ); ?></p>
			<h1 class="t-1"><?php esc_html_e( 'News, guides, and parts knowledge.', 'parts-mall' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Read updates from Parts-Mall Africa on branch support, spare-parts categories, trade supply, and the practical side of sourcing Korean vehicle parts in South Africa.', 'parts-mall' ); ?></p>
		</header>

		<div class="editorial-posts">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="editorial__content post-card" data-reveal>
						<p class="result-count"><?php echo esc_html( get_the_date() ); ?></p>
						<h2 class="t-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-card__excerpt"><?php the_excerpt(); ?></div>
						<a class="link-arrow" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'parts-mall' ); ?></a>
					</article>
				<?php endwhile; ?>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<div class="editorial__content" data-reveal>
					<h2 class="t-2"><?php esc_html_e( 'Nothing has been published here yet.', 'parts-mall' ); ?></h2>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
