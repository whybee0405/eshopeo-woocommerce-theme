<?php
/**
 * Generic page.
 *
 * Used for anything the site picks up later: privacy policy, terms, and so on.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<article class="section">
	<div class="wrap">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<header class="sectionhead">
				<h1 class="h2 sectionhead__title"><?php the_title(); ?></h1>
			</header>
			<div class="prose stack">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</article>

<?php
get_footer();
