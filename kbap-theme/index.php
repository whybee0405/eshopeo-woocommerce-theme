<?php
/**
 * Default index template.
 *
 * @package KBAP
 */

get_header();
?>
<section class="section">
	<div class="container">
		<p class="eyebrow"><?php esc_html_e( 'K-BAP', 'kbap' ); ?></p>
		<h1 class="t-1"><?php esc_html_e( 'Stories, updates and Korean food notes.', 'kbap' ); ?></h1>
		<?php if ( have_posts() ) : ?>
			<div class="dish-grid" style="margin-top:2rem">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'dish-card' ); ?>>
						<div class="dish-card__body">
							<h2 class="t-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="muted"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts yet.', 'kbap' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
