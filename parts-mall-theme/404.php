<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$catalogue_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/catalogue' );
?>

<div class="page-shell">
	<div class="container editorial">
		<div class="editorial__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( '404', 'parts-mall' ); ?></p>
			<h1 class="t-1"><?php esc_html_e( 'We could not find that page.', 'parts-mall' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Search the Parts-Mall catalogue by part, category, or make below, or jump into a popular category to keep moving.', 'parts-mall' ); ?></p>

			<form class="catalogue-search" data-catalogue-search method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="hidden" name="post_type" value="product">
				<div class="catalogue-search__fields">
					<input type="search" name="term" data-search-input placeholder="<?php esc_attr_e( 'Search the catalogue', 'parts-mall' ); ?>">
					<button class="btn btn--signal" type="submit"><?php esc_html_e( 'Search', 'parts-mall' ); ?></button>
				</div>
				<div class="catalogue-search__results" data-search-results aria-live="polite"></div>
			</form>

			<div class="cluster" style="margin-top:1.25rem;">
				<?php foreach ( array_slice( partsmall_category_groups(), 0, 5, true ) as $slug => $group ) : ?>
					<a class="badge badge--paper" href="<?php echo esc_url( add_query_arg( array( 'category[0]' => $slug ), $catalogue_url ) ); ?>"><?php echo esc_html( $group['label'] ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
