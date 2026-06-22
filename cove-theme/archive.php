<?php
/**
 * Archive template (categories, tags, author, date).
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<section class="section">
	<div class="container">

		<!-- Archive header -->
		<header class="section-head" style="margin-bottom:var(--s-7)">
			<div>
				<span class="eyebrow eyebrow--amber"><?php esc_html_e( 'The COVE Edit', 'cove' ); ?></span>
				<h1 class="t-1">
					<?php
					if ( is_category() ) {
						single_cat_title();
					} elseif ( is_tag() ) {
						/* translators: %s: tag name */
						printf( esc_html__( 'Tagged: %s', 'cove' ), single_tag_title( '', false ) );
					} elseif ( is_author() ) {
						/* translators: %s: author display name */
						printf( esc_html__( 'By %s', 'cove' ), esc_html( get_the_author() ) );
					} elseif ( is_year() ) {
						echo esc_html( get_the_date( 'Y' ) );
					} elseif ( is_month() ) {
						echo esc_html( get_the_date( 'F Y' ) );
					} else {
						esc_html_e( 'Archive', 'cove' );
					}
					?>
				</h1>
			</div>
		</header>

		<?php if ( have_posts() ) : ?>

			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					cove_post_card( get_post() );
				endwhile;
				?>
			</div><!-- .post-grid -->

			<div style="margin-top:var(--s-8);display:flex;justify-content:center">
				<?php
				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => esc_html__( '&larr; Newer', 'cove' ),
					'next_text' => esc_html__( 'Older &rarr;', 'cove' ),
				) );
				?>
			</div>

		<?php else : ?>
			<p class="t-lead" style="text-align:center;padding-block:var(--s-9)">
				<?php esc_html_e( 'No posts found in this archive.', 'cove' ); ?>
			</p>
		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
