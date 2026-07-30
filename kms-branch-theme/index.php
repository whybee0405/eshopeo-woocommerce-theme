<?php
/**
 * Fallback template.
 *
 * This site is three pages deep, so anything that lands here is sent to the
 * landing page rather than shown an empty archive.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="sectionhead">
				<h1 class="h2 sectionhead__title"><?php echo esc_html( wp_get_document_title() ); ?></h1>
			</div>
			<ul class="stack prose">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<li>
						<a class="h4" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php else : ?>
			<div class="sectionhead">
				<h1 class="h2 sectionhead__title"><?php esc_html_e( 'Nothing here', 'kms-branch' ); ?></h1>
				<p class="lede"><?php esc_html_e( 'Head back to the front page and pick a branch.', 'kms-branch' ); ?></p>
			</div>
			<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Back to the front page', 'kms-branch' ); ?>
				<?php kms_icon( 'arrow', array( 'size' => 18 ) ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
