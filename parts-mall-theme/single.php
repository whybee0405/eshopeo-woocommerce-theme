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
				<p class="eyebrow"><?php esc_html_e( 'Insights', 'parts-mall' ); ?></p>
				<h1 class="t-1"><?php the_title(); ?></h1>
				<div class="post-header-meta">
					<span class="result-count"><?php echo esc_html( get_the_date() ); ?></span>
					<?php
					$categories = get_the_category_list( ', ' );
					if ( $categories ) :
						?>
						<span class="result-count"><?php echo wp_kses_post( $categories ); ?></span>
					<?php endif; ?>
				</div>
			</header>

			<article class="editorial__content post-content" data-reveal>
				<?php the_content(); ?>
			</article>

			<section class="surface post-cta-band" data-reveal>
				<div>
					<h2 class="t-2"><?php esc_html_e( 'Need branch help or trade support?', 'parts-mall' ); ?></h2>
					<p class="muted"><?php esc_html_e( 'Use the branch finder to contact a local team quickly, or speak to head office for wholesale, campaigns, and routed support.', 'parts-mall' ); ?></p>
				</div>
				<div class="cluster">
					<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Find a branch', 'parts-mall' ); ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact head office', 'parts-mall' ); ?></a>
				</div>
			</section>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>
