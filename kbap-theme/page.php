<?php
/**
 * Default page template.
 *
 * @package KBAP
 */

get_header();
?>
<section class="section">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<p class="eyebrow"><?php esc_html_e( 'K-BAP', 'kbap' ); ?></p>
				<h1 class="t-1"><?php the_title(); ?></h1>
				<div class="lead"><?php the_content(); ?></div>
			</article>
		<?php endwhile; ?>
	</div>
</section>
<?php get_footer(); ?>
