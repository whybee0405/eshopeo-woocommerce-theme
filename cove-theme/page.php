<?php
/**
 * Generic page template.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="container section prose">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</div>

<?php get_footer(); ?>
