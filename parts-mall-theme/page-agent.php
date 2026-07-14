<?php
/**
 * Template Name: Become an Agent
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$profile = partsmall_site_profile();
$branch_total = 0;
foreach ( partsmall_branches() as $branch_group ) {
	$branch_total += count( $branch_group );
}
?>

<div class="page-shell">
	<div class="container agent-layout">
		<header class="page-hero" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Wholesale and franchise growth', 'parts-mall' ); ?></p>
			<h1 class="t-1"><?php the_title(); ?></h1>
			<p class="lead"><?php esc_html_e( 'Grow with Parts-Mall Africa through wholesale supply, trade support, workshop partnerships, fleet buying, or franchise expansion backed by a credible international group.', 'parts-mall' ); ?></p>
		</header>

		<div class="surface agent-stats-panel" data-reveal>
			<div class="agent-stats-grid">
				<div><strong class="t-2"><?php echo esc_html( number_format_i18n( $branch_total ) ); ?>+</strong><p class="muted"><?php esc_html_e( 'branch and country network points', 'parts-mall' ); ?></p></div>
				<div><strong class="t-2">63</strong><p class="muted"><?php esc_html_e( 'countries supplied by the group', 'parts-mall' ); ?></p></div>
				<div><strong class="t-2">189</strong><p class="muted"><?php esc_html_e( 'buyers referenced by the official corporate site', 'parts-mall' ); ?></p></div>
				<div><strong class="t-2">20+</strong><p class="muted"><?php esc_html_e( 'official agents globally', 'parts-mall' ); ?></p></div>
			</div>
		</div>

		<div class="agent-grid">
			<div class="editorial__content" data-reveal>
				<h2 class="t-2"><?php esc_html_e( 'Why partner with Parts-Mall Africa', 'parts-mall' ); ?></h2>
				<p><?php esc_html_e( 'The strength of the opportunity is the combination of aftermarket range, branch presence, local routing, private-brand support, and corporate experience that already understands scale.', 'parts-mall' ); ?></p>
				<p><?php esc_html_e( 'Whether you run a workshop, manage a fleet, supply trade customers, or want to grow into a stronger territory, Parts-Mall offers a more credible platform than a generic reseller relationship.', 'parts-mall' ); ?></p>
				<div class="cluster">
					<a class="btn btn--signal" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Review the branch network', 'parts-mall' ); ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( partsmall_head_office_map_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Head office directions', 'parts-mall' ); ?></a>
				</div>
			</div>

			<div class="form-card" data-reveal>
				<h2 class="t-2"><?php esc_html_e( 'Start the conversation', 'parts-mall' ); ?></h2>
				<form data-enquiry-form>
					<input type="hidden" name="type" value="agent">
					<div class="form-grid">
						<div><label class="label"><?php esc_html_e( 'Name', 'parts-mall' ); ?><input type="text" name="name" required></label></div>
						<div><label class="label"><?php esc_html_e( 'Company', 'parts-mall' ); ?><input type="text" name="company"></label></div>
						<div><label class="label"><?php esc_html_e( 'Email', 'parts-mall' ); ?><input type="email" name="email"></label></div>
						<div><label class="label"><?php esc_html_e( 'Contact number', 'parts-mall' ); ?><input type="text" name="phone"></label></div>
						<div class="field--full"><label class="label"><?php esc_html_e( 'Area of interest', 'parts-mall' ); ?><input type="text" name="area" placeholder="<?php esc_attr_e( 'Province, country, territory, workshop network, or fleet base', 'parts-mall' ); ?>"></label></div>
						<div class="field--full"><label class="label"><?php esc_html_e( 'Tell us about your business', 'parts-mall' ); ?><textarea name="message" placeholder="<?php esc_attr_e( 'Share your customer base, growth plans, vehicle focus, branch footprint, or supply requirements.', 'parts-mall' ); ?>"></textarea></label></div>
					</div>
					<p class="form-note"><?php echo esc_html( $profile['tagline'] ); ?></p>
					<div class="cluster">
						<button type="submit" class="btn btn--signal"><?php esc_html_e( 'Send commercial enquiry', 'parts-mall' ); ?></button>
						<div class="form-status" data-form-status role="status" aria-live="polite"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
