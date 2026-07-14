<?php
/**
 * Dynamic branch detail template.
 *
 * Branches are resolved by the /branches/{slug}/ rewrite route and sourced
 * from the partsmall_branch_directory option.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$branch = isset( $GLOBALS['partsmall_current_branch'] ) && is_array( $GLOBALS['partsmall_current_branch'] )
	? $GLOBALS['partsmall_current_branch']
	: partsmall_get_branch_by_slug( (string) get_query_var( 'partsmall_branch' ) );

if ( ! $branch ) {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( '404' );
	return;
}

$title      = sprintf( 'Parts-Mall %s', $branch['name'] );
$tel        = partsmall_normalize_phone( $branch['phone'] );
$map_url    = partsmall_branch_map_url( $branch );
$directions = partsmall_branch_directions_url( $branch );
$whatsapp   = partsmall_branch_whatsapp_url( $branch );
$gallery    = ! empty( $branch['gallery'] ) && is_array( $branch['gallery'] ) ? $branch['gallery'] : partsmall_branch_default_gallery();

get_header();
?>

<div class="branch-detail page-shell" data-branch-slug="<?php echo esc_attr( $branch['slug'] ); ?>" data-branch-name="<?php echo esc_attr( $branch['name'] ); ?>">
	<div class="container editorial">
		<header class="page-hero branch-detail__hero" data-reveal>
			<div>
				<p class="eyebrow"><?php echo esc_html( $branch['province'] ); ?></p>
				<h1 class="t-1"><?php echo esc_html( $title ); ?></h1>
				<p class="lead"><?php echo esc_html( sprintf( __( 'Contact the %s team for Korean vehicle parts, stock checks, OEM cross-references, trade support, and fast local assistance.', 'parts-mall' ), $branch['name'] ) ); ?></p>
			</div>
			<div class="branch-detail__summary">
				<span class="badge badge--signal"><?php echo esc_html( $branch['country'] ); ?></span>
				<span class="badge badge--navy"><?php echo esc_html( $branch['hours'] ); ?></span>
			</div>
		</header>

		<section class="branch-cta-grid" aria-label="<?php esc_attr_e( 'Branch contact actions', 'parts-mall' ); ?>" data-reveal>
			<a class="btn btn--signal" href="tel:<?php echo esc_attr( $tel ); ?>"><?php esc_html_e( 'Call branch', 'parts-mall' ); ?></a>
			<a class="btn btn--outline" href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp', 'parts-mall' ); ?></a>
			<a class="btn btn--outline" href="<?php echo esc_url( $directions ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Get directions', 'parts-mall' ); ?></a>
		</section>

		<div class="branch-contact-layout">
			<section class="form-card branch-detail__info" data-reveal>
				<h2 class="t-2"><?php esc_html_e( 'Branch details', 'parts-mall' ); ?></h2>
				<dl class="branch-detail__list">
					<div>
						<dt><?php esc_html_e( 'Address', 'parts-mall' ); ?></dt>
						<dd><?php echo esc_html( $branch['address'] ); ?></dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'Phone', 'parts-mall' ); ?></dt>
						<dd><a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $branch['phone'] ); ?></a></dd>
					</div>
					<?php if ( ! empty( $branch['email'] ) ) : ?>
						<div>
							<dt><?php esc_html_e( 'Email', 'parts-mall' ); ?></dt>
							<dd><a href="mailto:<?php echo esc_attr( $branch['email'] ); ?>"><?php echo esc_html( $branch['email'] ); ?></a></dd>
						</div>
					<?php endif; ?>
					<div>
						<dt><?php esc_html_e( 'Hours', 'parts-mall' ); ?></dt>
						<dd><?php echo esc_html( $branch['hours'] ); ?></dd>
					</div>
				</dl>
				<a class="link-arrow" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open in Google Maps', 'parts-mall' ); ?> -></a>
			</section>

			<section class="form-card" data-reveal>
				<h2 class="t-2"><?php esc_html_e( 'Ask this branch', 'parts-mall' ); ?></h2>
				<form data-enquiry-form>
					<input type="hidden" name="type" value="branch">
					<input type="hidden" name="branch_slug" value="<?php echo esc_attr( $branch['slug'] ); ?>">
					<input type="hidden" name="branch_name" value="<?php echo esc_attr( $branch['name'] ); ?>">
					<div class="form-grid">
						<div><label class="label"><?php esc_html_e( 'Name', 'parts-mall' ); ?><input type="text" name="name" required></label></div>
						<div><label class="label"><?php esc_html_e( 'Company', 'parts-mall' ); ?><input type="text" name="company"></label></div>
						<div><label class="label"><?php esc_html_e( 'Email', 'parts-mall' ); ?><input type="email" name="email"></label></div>
						<div><label class="label"><?php esc_html_e( 'Contact number', 'parts-mall' ); ?><input type="text" name="phone"></label></div>
						<div class="field--full"><label class="label"><?php esc_html_e( 'Part or enquiry details', 'parts-mall' ); ?><textarea name="message" placeholder="<?php esc_attr_e( 'Include the part number, vehicle make and model, VIN, quantity, or OEM reference if available.', 'parts-mall' ); ?>"></textarea></label></div>
					</div>
					<div class="cluster">
						<button type="submit" class="btn btn--signal"><?php esc_html_e( 'Send to branch', 'parts-mall' ); ?></button>
						<div class="form-status" data-form-status role="status" aria-live="polite"></div>
					</div>
				</form>
			</section>
		</div>

		<section class="branch-gallery" aria-label="<?php esc_attr_e( 'Branch media', 'parts-mall' ); ?>" data-reveal>
			<div class="branch-gallery__head">
				<h2 class="t-2"><?php esc_html_e( 'Branch gallery', 'parts-mall' ); ?></h2>
				<p class="result-count"><?php esc_html_e( 'Show real branch photography here so customers can recognise the location, team, and service environment before they arrive.', 'parts-mall' ); ?></p>
			</div>
			<?php if ( ! empty( $gallery ) ) : ?>
				<div class="branch-gallery__grid">
					<?php foreach ( $gallery as $image ) : ?>
						<figure class="branch-gallery__item">
							<img src="<?php echo esc_url( $image['src'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" loading="lazy" decoding="async">
						</figure>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="branch-media-checklist">
					<article class="branch-media-card">
						<strong><?php esc_html_e( 'Exterior storefront photo', 'parts-mall' ); ?></strong>
						<p><?php esc_html_e( 'Use a clear street-facing image that helps customers recognise the branch on arrival.', 'parts-mall' ); ?></p>
					</article>
					<article class="branch-media-card">
						<strong><?php esc_html_e( 'Counter or team photo', 'parts-mall' ); ?></strong>
						<p><?php esc_html_e( 'Show the branch environment, support desk, or stocked counter to make the page feel local and trustworthy.', 'parts-mall' ); ?></p>
					</article>
					<article class="branch-media-card">
						<strong><?php esc_html_e( 'Local route and service area', 'parts-mall' ); ?></strong>
						<p><?php esc_html_e( 'Support the gallery with suburb, city, and province-specific content that reflects how this branch serves its local market.', 'parts-mall' ); ?></p>
						<a class="link-arrow" href="<?php echo esc_url( $directions ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open directions', 'parts-mall' ); ?> &rarr;</a>
					</article>
				</div>
			<?php endif; ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>
