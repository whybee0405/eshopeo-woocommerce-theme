<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$profile         = partsmall_site_profile();
$branches        = partsmall_branches();
$global_locations = partsmall_global_locations();
$network_proof   = partsmall_network_proof();
$promotions      = partsmall_promotions();
$insights        = partsmall_latest_insights( 3 );
$timeline        = partsmall_group_timeline();
$category_copy   = partsmall_category_directory();
$display_brands  = partsmall_private_brands();
unset( $display_brands['oem-genuine'] );

$local_count    = 0;
$province_count = 0;
$pan_count      = isset( $branches['Pan-Africa'] ) ? count( $branches['Pan-Africa'] ) : 0;
foreach ( $branches as $province => $items ) {
	if ( 'Pan-Africa' === $province ) {
		continue;
	}
	$province_count++;
	$local_count += count( $items );
}

$branch_index = array_values( partsmall_flatten_branches() );
$branch_preview = array_slice( $branch_index, 0, 4 );
$cloudia_slider = '';
if ( function_exists( 'cloudia_hero_slider_render' ) ) {
	$cloudia_slider = cloudia_hero_slider_render(
		array(
			'alias' => 'homepage-hero',
			'class' => 'partsmall-homepage-hero',
		),
		false
	);
}
?>

<?php if ( ! empty( $cloudia_slider ) ) : ?>
	<?php echo $cloudia_slider; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php else : ?>
	<section class="hero hero--brand">
		<div class="hero-media" data-hero-slider-slot>
			<img src="<?php echo esc_url( get_theme_file_uri( 'images/generated-concepts/parts-mall-hero-distribution-hub.png' ) ); ?>" alt="<?php esc_attr_e( 'Automotive parts distribution environment representing Parts-Mall Africa supply capability', 'parts-mall' ); ?>" loading="eager" decoding="async">
		</div>
		<div class="container hero__layout hero__layout--brand">
			<div class="hero__copy" data-reveal>
				<p class="eyebrow"><?php echo esc_html( $profile['tagline'] ); ?></p>
				<h1 class="t-hero"><?php echo esc_html( $profile['headline'] ); ?></h1>
				<p class="lead"><?php echo esc_html( $profile['hero_copy'] ); ?></p>
				<div class="cluster hero-actions">
					<?php foreach ( $profile['campaign_actions'] as $action ) : ?>
						<a class="btn <?php echo 'signal' === $action['tone'] ? 'btn--signal' : 'btn--outline'; ?>" href="<?php echo esc_url( $action['url'] ); ?>"><?php echo esc_html( $action['label'] ); ?></a>
					<?php endforeach; ?>
				</div>
				<ul class="hero-proof-list" aria-label="<?php esc_attr_e( 'Core proof points', 'parts-mall' ); ?>">
					<?php foreach ( $profile['proof_points'] as $point ) : ?>
						<li><?php echo esc_html( $point ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="hero-card hero-card--proof" data-reveal>
				<div class="section-head">
					<div class="section-head__text">
						<h2 class="t-2"><?php esc_html_e( 'Trusted supply network', 'parts-mall' ); ?></h2>
					</div>
				</div>
				<div class="proof-grid">
					<?php foreach ( $profile['corporate_facts'] as $fact ) : ?>
						<div class="proof-stat">
							<strong><?php echo esc_html( $fact['value'] ); ?></strong>
							<span><?php echo esc_html( $fact['label'] ); ?></span>
							<small><?php echo esc_html( $fact['note'] ); ?></small>
						</div>
					<?php endforeach; ?>
				</div>
				<p class="hero-card__caption"><?php esc_html_e( 'Backed by an established international aftermarket group with local branch support.', 'parts-mall' ); ?></p>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section section--tight trust-band">
	<div class="container trust-band__grid" data-reveal>
		<div class="trust-band__intro">
			<p class="eyebrow"><?php esc_html_e( 'Why choose Parts-Mall', 'parts-mall' ); ?></p>
			<h2 class="t-1"><?php esc_html_e( 'Parts supply for branches, workshops, and trade customers.', 'parts-mall' ); ?></h2>
		</div>
		<div class="trust-band__metrics">
			<div><strong><?php echo esc_html( number_format_i18n( $local_count + $pan_count ) ); ?>+</strong><span><?php esc_html_e( 'branch and regional points', 'parts-mall' ); ?></span></div>
			<div><strong><?php echo esc_html( number_format_i18n( $province_count ) ); ?></strong><span><?php esc_html_e( 'South African province groups', 'parts-mall' ); ?></span></div>
			<div><strong><?php echo esc_html( number_format_i18n( count( $display_brands ) ) ); ?></strong><span><?php esc_html_e( 'private-brand lines', 'parts-mall' ); ?></span></div>
			<div><strong>25+</strong><span><?php esc_html_e( 'years of aftermarket experience', 'parts-mall' ); ?></span></div>
		</div>
	</div>
</section>

<section class="section section--tight locator-preview">
	<div class="container locator-preview__layout">
		<div class="stack" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Find your nearest branch.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<p class="lead"><?php esc_html_e( 'Search by branch, city, province, or country and contact the right team fast.', 'parts-mall' ); ?></p>
			<div class="locator-search shell-search" data-branch-finder>
				<label class="sr-only" for="home-branch-search"><?php esc_html_e( 'Search branches', 'parts-mall' ); ?></label>
				<input id="home-branch-search" type="search" data-branch-finder-input placeholder="<?php esc_attr_e( 'Search by branch, city, province, or country', 'parts-mall' ); ?>">
			</div>
			<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Open full branch finder', 'parts-mall' ); ?></a>
		</div>

		<div class="locator-preview__cards" data-reveal>
			<?php foreach ( $branch_preview as $branch ) : ?>
				<article class="branch-spotlight" data-branch-card data-branch-search="<?php echo esc_attr( strtolower( implode( ' ', array_filter( array( $branch['name'], $branch['province'], $branch['address'], $branch['country'] ) ) ) ) ); ?>">
					<div class="branch-spotlight__meta">
						<span class="badge badge--navy"><?php echo esc_html( $branch['province'] ); ?></span>
						<?php if ( ! empty( $branch['country'] ) && 'South Africa' !== $branch['country'] ) : ?>
							<span class="badge badge--signal"><?php echo esc_html( $branch['country'] ); ?></span>
						<?php endif; ?>
					</div>
					<h3 class="t-3"><?php echo esc_html( $branch['name'] ); ?></h3>
					<p class="muted"><?php echo esc_html( $branch['address'] ); ?></p>
					<div class="cluster branch-spotlight__actions">
						<a class="link-arrow" href="<?php echo esc_url( partsmall_branch_url( $branch ) ); ?>"><?php esc_html_e( 'View branch page', 'parts-mall' ); ?></a>
						<a class="link-arrow" href="tel:<?php echo esc_attr( partsmall_normalize_phone( $branch['phone'] ) ); ?>"><?php esc_html_e( 'Call', 'parts-mall' ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tight global-network" id="global-network">
	<div class="container global-network__layout">
		<div class="global-network__media" data-reveal>
			<img src="<?php echo esc_url( get_theme_file_uri( 'images/generated-concepts/parts-mall-global-network-map.png' ) ); ?>" alt="<?php esc_attr_e( 'Global Parts-Mall network concept linking South Korea, South Africa, China, and wider export markets', 'parts-mall' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="stack" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Local service with international backing.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<p class="lead"><?php esc_html_e( 'Parts-Mall serves customers through a wider global aftermarket network with strong supply and brand support.', 'parts-mall' ); ?></p>
			<div class="global-network__list">
				<?php foreach ( $global_locations as $location ) : ?>
					<div class="network-node">
						<strong><?php echo esc_html( $location['label'] ); ?></strong>
						<span><?php echo esc_html( $location['place'] ); ?></span>
						<small><?php echo esc_html( $location['type'] ); ?></small>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="section section--tight" id="brands">
	<div class="container">
		<div class="stack" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Brands you can trust.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<p class="lead"><?php esc_html_e( 'Our private-brand range supports everyday workshop, branch, and trade demand for Korean vehicle parts.', 'parts-mall' ); ?></p>
		</div>

		<div class="brand-story-grid" style="margin-top:1.5rem;">
			<?php foreach ( $display_brands as $brand ) : ?>
				<article class="brand-story" data-reveal>
					<img src="<?php echo esc_url( $brand['logo'] ); ?>" alt="<?php echo esc_attr( $brand['label'] ); ?>">
					<h3 class="t-3"><?php echo esc_html( $brand['label'] ); ?></h3>
					<p class="muted"><?php esc_html_e( 'Quality aftermarket supply backed by the Parts-Mall network.', 'parts-mall' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tight timeline-band">
	<div class="container">
		<div class="stack" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Built on decades of parts experience.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<p class="lead"><?php esc_html_e( 'A long operating history supports customer confidence, branch growth, and wholesale supply.', 'parts-mall' ); ?></p>
		</div>
		<div class="timeline-grid" data-reveal>
			<?php foreach ( $timeline as $item ) : ?>
				<div class="timeline-item">
					<strong><?php echo esc_html( $item['year'] ); ?></strong>
					<p><?php echo esc_html( $item['event'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tight promo-section">
	<div class="container">
		<div class="cluster cluster--between" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Latest offers and branch highlights.', 'parts-mall' ); ?></h2>
				</div>
			</div>
		</div>
		<div class="promo-slider" data-promo-slider data-reveal>
			<div class="promo-slider__viewport">
				<?php foreach ( $promotions as $index => $slide ) : ?>
					<article class="promo-slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-promo-slide>
						<p class="eyebrow"><?php echo esc_html( $slide['eyebrow'] ); ?></p>
						<h3 class="t-2"><?php echo esc_html( $slide['title'] ); ?></h3>
						<p class="lead"><?php echo esc_html( $slide['body'] ); ?></p>
						<a class="btn btn--signal" href="<?php echo esc_url( $slide['url'] ); ?>"><?php echo esc_html( $slide['cta'] ); ?></a>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="promo-slider__controls">
				<button class="icon-btn" type="button" data-promo-prev aria-label="<?php esc_attr_e( 'Previous promotion', 'parts-mall' ); ?>">&larr;</button>
				<div class="promo-slider__dots" aria-label="<?php esc_attr_e( 'Promotion slides', 'parts-mall' ); ?>">
					<?php foreach ( $promotions as $index => $slide ) : ?>
						<button type="button" class="promo-slider__dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-promo-dot aria-label="<?php echo esc_attr( sprintf( __( 'Show promotion %d', 'parts-mall' ), $index + 1 ) ); ?>"></button>
					<?php endforeach; ?>
				</div>
				<button class="icon-btn" type="button" data-promo-next aria-label="<?php esc_attr_e( 'Next promotion', 'parts-mall' ); ?>">&rarr;</button>
			</div>
		</div>
	</div>
</section>

<section class="section section--tight reviews-band" id="reviews">
	<div class="container">
		<div class="stack" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Why customers buy from Parts-Mall.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<p class="lead"><?php esc_html_e( 'Our branch footprint, product range, and group backing help customers buy with confidence.', 'parts-mall' ); ?></p>
		</div>
		<div class="review-grid" style="margin-top:1.5rem;">
			<?php foreach ( $network_proof as $item ) : ?>
				<article class="review-card review-card--proof" data-reveal>
					<span class="badge <?php echo 'signal' === $item['tone'] ? 'badge--signal' : ( 'navy' === $item['tone'] ? 'badge--navy' : 'badge--paper' ); ?>"><?php echo esc_html( $item['label'] ); ?></span>
					<p class="t-3"><?php echo esc_html( $item['value'] ); ?></p>
					<footer>
						<span><?php echo esc_html( $item['detail'] ); ?></span>
					</footer>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tight category-authority" id="category-authority">
	<div class="container category-authority__layout">
		<div class="stack" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Spare parts categories we supply.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<p class="lead"><?php esc_html_e( 'Browse the main parts categories available through Parts-Mall branches and trade channels.', 'parts-mall' ); ?></p>
		</div>
		<div class="category-authority__list" data-reveal>
			<?php foreach ( $category_copy as $item ) : ?>
				<div class="authority-chip"><?php echo esc_html( $item ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tight insights-section" id="insights">
	<div class="container">
		<div class="cluster cluster--between" data-reveal>
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'News, guides, and updates.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<a class="link-arrow" href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'Learn more about Parts-Mall', 'parts-mall' ); ?></a>
		</div>
		<div class="insight-grid" style="margin-top:1.5rem;">
			<?php foreach ( $insights as $item ) : ?>
				<article class="insight-card" data-reveal>
					<h3 class="t-3"><?php echo esc_html( $item['title'] ); ?></h3>
					<p class="muted"><?php echo esc_html( $item['excerpt'] ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( $item['url'] ); ?>"><?php esc_html_e( 'Read more', 'parts-mall' ); ?></a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tight contact-band">
	<div class="container contact-band__layout surface" data-reveal>
		<div class="stack">
			<div class="section-head">
				<div class="section-head__text">
					<h2 class="t-1"><?php esc_html_e( 'Contact head office.', 'parts-mall' ); ?></h2>
				</div>
			</div>
			<p class="lead"><?php esc_html_e( 'Speak to our team for wholesale, branch support, trade enquiries, and general assistance.', 'parts-mall' ); ?></p>
		</div>
		<div class="contact-band__actions">
			<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact head office', 'parts-mall' ); ?></a>
			<a class="btn btn--outline" href="mailto:<?php echo esc_attr( $profile['head_office_email'] ); ?>"><?php esc_html_e( 'Email sales desk', 'parts-mall' ); ?></a>
			<a class="btn btn--outline" href="<?php echo esc_url( partsmall_head_office_map_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Directions to Meadowdale', 'parts-mall' ); ?></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
