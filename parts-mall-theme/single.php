<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="page-shell">
	<div class="container editorial">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$related_posts = new WP_Query(
				array(
					'post_type'           => 'post',
					'posts_per_page'      => 3,
					'post__not_in'        => array( get_the_ID() ),
					'ignore_sticky_posts' => true,
				)
			);
			$posts_page_url = get_option( 'page_for_posts' ) ? get_permalink( (int) get_option( 'page_for_posts' ) ) : home_url( '/' );
			?>
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

			<?php if ( $related_posts->have_posts() ) : ?>
				<section class="surface related-insights" data-reveal>
					<div class="cluster cluster--between related-insights__head">
						<div>
							<p class="eyebrow"><?php esc_html_e( 'More insights', 'parts-mall' ); ?></p>
							<h2 class="t-2"><?php esc_html_e( 'Keep exploring Parts-Mall Africa.', 'parts-mall' ); ?></h2>
						</div>
						<a class="btn btn--outline btn--sm" href="<?php echo esc_url( $posts_page_url ); ?>"><?php esc_html_e( 'View articles', 'parts-mall' ); ?></a>
					</div>
					<div class="insights-mini-grid">
						<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
							<article class="insight-mini-card">
								<p class="result-count"><?php echo esc_html( get_the_date() ); ?></p>
								<h3 class="t-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="muted"><?php the_excerpt(); ?></div>
								<a class="link-arrow" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'parts-mall' ); ?></a>
							</article>
						<?php endwhile; ?>
					</div>
				</section>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>
