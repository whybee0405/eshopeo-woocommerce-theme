<?php
/**
 * Template Name: Find a Branch
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( function_exists( 'cloudia_store_locator_render' ) ) :
?>
<div class="page-shell">
	<div class="container editorial">
		<header class="page-hero" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Find a branch', 'parts-mall' ); ?></p>
			<h1 class="t-1"><?php the_title(); ?></h1>
			<p class="lead"><?php esc_html_e( 'Find your nearest Parts-Mall branch, use your current location, and connect quickly by phone, WhatsApp, directions, or local enquiry form.', 'parts-mall' ); ?></p>
		</header>
		<?php cloudia_store_locator_render( array( 'title' => __( 'Find your nearest Parts-Mall branch', 'parts-mall' ) ) ); ?>
	</div>
</div>
<?php
get_footer();
return;
endif;

$branches    = partsmall_branches();
$pan_africa  = isset( $branches['Pan-Africa'] ) ? $branches['Pan-Africa'] : array();
unset( $branches['Pan-Africa'] );
$all_branches    = array_values( partsmall_flatten_branches() );
$featured_branch = ! empty( $all_branches ) ? $all_branches[0] : null;
?>

<div class="page-shell">
	<div class="container editorial">
		<header class="page-hero" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Find a branch', 'parts-mall' ); ?></p>
			<h1 class="t-1"><?php the_title(); ?></h1>
			<p class="lead"><?php esc_html_e( 'Search by branch, suburb, city, province, or country to reach the right Parts-Mall team for local support, directions, and branch-specific enquiries.', 'parts-mall' ); ?></p>
		</header>

		<div class="branch-finder__intro" data-reveal>
			<div class="branch-finder-toolbar" data-branch-finder>
				<input type="search" data-branch-finder-input placeholder="<?php esc_attr_e( 'Search branches, suburbs, cities, provinces, or countries', 'parts-mall' ); ?>">
				<div class="branch-finder-toolbar__meta">
					<p class="result-count" data-branch-results><?php printf( esc_html__( '%s branch points currently visible', 'parts-mall' ), esc_html( number_format_i18n( count( $all_branches ) ) ) ); ?></p>
				</div>
				<a class="btn btn--outline" href="<?php echo esc_url( partsmall_head_office_map_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Head office directions', 'parts-mall' ); ?></a>
			</div>
			<img class="surface" src="<?php echo esc_url( get_theme_file_uri( 'images/generated-concepts/parts-mall-global-network-map.png' ) ); ?>" alt="<?php esc_attr_e( 'Parts-Mall network map concept showing local and international reach', 'parts-mall' ); ?>" loading="lazy" decoding="async">
		</div>

		<?php if ( $featured_branch ) : ?>
			<section class="locator-feature surface" data-branch-featured data-reveal>
				<div class="locator-feature__intro">
					<p class="eyebrow"><?php esc_html_e( 'Best current match', 'parts-mall' ); ?></p>
					<h2 class="t-2" data-branch-featured-name><?php echo esc_html( $featured_branch['name'] ); ?></h2>
					<p class="muted" data-branch-featured-address><?php echo esc_html( $featured_branch['address'] ); ?></p>
				</div>
				<div class="locator-feature__actions">
					<a class="btn btn--signal" data-branch-featured-link href="<?php echo esc_url( partsmall_branch_url( $featured_branch ) ); ?>"><?php esc_html_e( 'Open branch page', 'parts-mall' ); ?></a>
					<a class="btn btn--outline" data-branch-featured-call href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $featured_branch['phone'] ) ); ?>"><?php esc_html_e( 'Call branch', 'parts-mall' ); ?></a>
					<a class="btn btn--outline" data-branch-featured-directions href="<?php echo esc_url( partsmall_branch_directions_url( $featured_branch ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Directions', 'parts-mall' ); ?></a>
				</div>
			</section>
		<?php endif; ?>

		<div class="catalogue__empty locator-empty" data-branch-empty hidden>
			<p class="eyebrow"><?php esc_html_e( 'No matching branch found', 'parts-mall' ); ?></p>
			<h2 class="t-2"><?php esc_html_e( 'Try a nearby suburb, city, province, or country name instead.', 'parts-mall' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'If you are unsure which branch should help, contact head office and the enquiry will be routed to the right team.', 'parts-mall' ); ?></p>
			<div class="cluster">
				<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact head office', 'parts-mall' ); ?></a>
				<a class="btn btn--outline" href="<?php echo esc_url( partsmall_head_office_map_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Head office directions', 'parts-mall' ); ?></a>
			</div>
		</div>

		<div class="branches-grid">
			<?php foreach ( $branches as $province => $items ) : ?>
				<section class="branch-group" data-reveal data-branch-group>
					<div class="branch-group__header">
						<div>
								<h2 class="t-2"><?php echo esc_html( $province ); ?></h2>
							</div>
						<span class="result-count" data-branch-group-count><?php echo esc_html( number_format_i18n( count( $items ) ) ); ?> <?php esc_html_e( 'locations', 'parts-mall' ); ?></span>
					</div>
					<div class="branch-group__cards">
						<?php foreach ( $items as $branch ) : ?>
							<?php $branch = partsmall_prepare_branch( $branch, (string) $province ); ?>
							<article class="branch-card" data-branch-card data-branch-name="<?php echo esc_attr( $branch['name'] ); ?>" data-branch-address="<?php echo esc_attr( $branch['address'] ); ?>" data-branch-phone="<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $branch['phone'] ) ); ?>" data-branch-url="<?php echo esc_url( partsmall_branch_url( $branch ) ); ?>" data-branch-directions="<?php echo esc_url( partsmall_branch_directions_url( $branch ) ); ?>" data-branch-search="<?php echo esc_attr( strtolower( implode( ' ', array_filter( array( $branch['name'], $branch['province'], $branch['address'], $branch['country'] ) ) ) ) ); ?>">
								<h3 class="t-3"><?php echo esc_html( $branch['name'] ); ?></h3>
								<div class="branch-card__meta"><?php echo esc_html( $branch['address'] ); ?></div>
								<div class="branch-card__links">
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $branch['phone'] ) ); ?>"><?php echo esc_html( $branch['phone'] ); ?></a>
									<?php if ( ! empty( $branch['email'] ) ) : ?>
										<a href="mailto:<?php echo esc_attr( $branch['email'] ); ?>"><?php echo esc_html( $branch['email'] ); ?></a>
									<?php endif; ?>
									<a class="link-arrow" href="<?php echo esc_url( partsmall_branch_url( $branch ) ); ?>"><?php esc_html_e( 'View branch', 'parts-mall' ); ?> &rarr;</a>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>

			<?php if ( ! empty( $pan_africa ) ) : ?>
				<section class="branch-group" id="pan-africa" data-reveal data-branch-group>
					<div class="branch-group__header">
						<div>
								<h2 class="t-2"><?php esc_html_e( 'Pan-Africa', 'parts-mall' ); ?></h2>
							</div>
						<span class="result-count" data-branch-group-count><?php echo esc_html( number_format_i18n( count( $pan_africa ) ) ); ?> <?php esc_html_e( 'country points', 'parts-mall' ); ?></span>
					</div>
					<div class="branch-group__cards">
						<?php foreach ( $pan_africa as $branch ) : ?>
							<?php $branch = partsmall_prepare_branch( $branch, 'Pan-Africa' ); ?>
							<article class="branch-card" data-branch-card data-branch-name="<?php echo esc_attr( $branch['country'] ); ?>" data-branch-address="<?php echo esc_attr( $branch['address'] ); ?>" data-branch-phone="<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $branch['phone'] ) ); ?>" data-branch-url="<?php echo esc_url( partsmall_branch_url( $branch ) ); ?>" data-branch-directions="<?php echo esc_url( partsmall_branch_directions_url( $branch ) ); ?>" data-branch-search="<?php echo esc_attr( strtolower( implode( ' ', array_filter( array( $branch['name'], $branch['province'], $branch['address'], $branch['country'] ) ) ) ) ); ?>">
								<h3 class="t-3"><?php echo esc_html( $branch['country'] ); ?></h3>
								<div class="branch-card__meta"><?php echo esc_html( $branch['address'] ); ?></div>
								<div class="branch-card__links">
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $branch['phone'] ) ); ?>"><?php echo esc_html( $branch['phone'] ); ?></a>
									<?php if ( ! empty( $branch['email'] ) ) : ?>
										<a href="mailto:<?php echo esc_attr( $branch['email'] ); ?>"><?php echo esc_html( $branch['email'] ); ?></a>
									<?php endif; ?>
									<a class="link-arrow" href="<?php echo esc_url( partsmall_branch_url( $branch ) ); ?>"><?php esc_html_e( 'View branch', 'parts-mall' ); ?> &rarr;</a>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
