<?php
/**
 * Single post template.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<article <?php post_class(); ?>>

	<!-- Post header -->
	<div class="container">
		<header class="post-header" data-reveal>
			<?php
			$cats      = get_the_category();
			$words     = str_word_count( wp_strip_all_tags( get_the_content() ) );
			$read_time = max( 1, (int) ceil( $words / 200 ) );
			?>
			<?php if ( ! empty( $cats ) ) : ?>
				<span class="eyebrow eyebrow--amber" style="margin-bottom:var(--s-4)"><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
			<h1 class="t-1" style="margin-bottom:var(--s-4)"><?php the_title(); ?></h1>
			<p class="t-mono muted">
				<?php echo esc_html( get_the_date() ); ?>
				<span aria-hidden="true">&nbsp;&middot;&nbsp;</span>
				<?php printf( esc_html( _n( '%d min read', '%d min read', $read_time, 'cove' ) ), (int) $read_time ); ?>
			</p>
		</header>
	</div>

	<!-- Featured image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="container" style="margin-bottom:var(--s-7)">
			<div style="aspect-ratio:16/7;border-radius:var(--r-l);overflow:hidden;background:var(--cream-deep)">
				<?php the_post_thumbnail( 'full', array( 'style' => 'width:100%;height:100%;object-fit:cover;' ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Post content -->
	<div class="container">
		<div class="post-content" data-reveal>
			<?php the_content(); ?>
		</div>

		<!-- Author / back link -->
		<div style="max-width:720px;margin-inline:auto;padding-block:var(--s-6);border-top:1.5px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:var(--s-4);flex-wrap:wrap">
			<span class="t-mono muted"><?php echo esc_html( get_the_author() ); ?></span>
			<a class="link-arrow" href="<?php echo esc_url( home_url( '/blog' ) ); ?>" style="flex-direction:row-reverse">
				<?php esc_html_e( 'All posts', 'cove' ); ?>
			</a>
		</div>
	</div>

</article>

<?php endwhile; ?>

<?php get_footer(); ?>
