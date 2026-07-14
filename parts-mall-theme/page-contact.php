<?php
/**
 * Template Name: Contact
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$profile = partsmall_site_profile();
?>

<div class="page-shell">
	<div class="container contact-layout">
		<header class="page-hero" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Contact', 'parts-mall' ); ?></p>
			<h1 class="t-1"><?php the_title(); ?></h1>
			<p class="lead"><?php esc_html_e( 'Contact Parts-Mall Africa for head office support, wholesale conversations, campaign enquiries, or help getting to the right branch.', 'parts-mall' ); ?></p>
		</header>

		<div class="contact-grid">
			<div class="form-card" data-reveal>
				<h2 class="t-2"><?php esc_html_e( 'Head office details', 'parts-mall' ); ?></h2>
				<p><?php esc_html_e( 'Meadowdale is the main contact point for head office enquiries, commercial discussions, marketing campaigns, and support that needs to be routed beyond a single branch.', 'parts-mall' ); ?></p>
				<p><strong><?php esc_html_e( 'Email', 'parts-mall' ); ?>:</strong> <a href="mailto:<?php echo esc_attr( $profile['head_office_email'] ); ?>"><?php echo esc_html( $profile['head_office_email'] ); ?></a></p>
				<p><strong><?php esc_html_e( 'Address', 'parts-mall' ); ?>:</strong> <?php echo esc_html( implode( ', ', $profile['head_office_address'] ) ); ?></p>
				<p><strong><?php esc_html_e( 'Hours', 'parts-mall' ); ?>:</strong> <?php esc_html_e( 'Monday to Friday, 08:00-17:00 SAST', 'parts-mall' ); ?></p>
				<div class="cluster">
					<a class="btn btn--signal" href="<?php echo esc_url( partsmall_head_office_map_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Directions', 'parts-mall' ); ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/find-a-branch' ) ); ?>"><?php esc_html_e( 'Open the branch finder', 'parts-mall' ); ?></a>
				</div>
			</div>

			<div class="form-card" data-reveal>
				<h2 class="t-2"><?php esc_html_e( 'Send an enquiry', 'parts-mall' ); ?></h2>
				<form data-enquiry-form>
					<input type="hidden" name="type" value="contact">
					<div class="form-grid">
						<div><label class="label"><?php esc_html_e( 'Name', 'parts-mall' ); ?><input type="text" name="name" required></label></div>
						<div><label class="label"><?php esc_html_e( 'Company', 'parts-mall' ); ?><input type="text" name="company"></label></div>
						<div><label class="label"><?php esc_html_e( 'Email', 'parts-mall' ); ?><input type="email" name="email"></label></div>
						<div><label class="label"><?php esc_html_e( 'Contact number', 'parts-mall' ); ?><input type="text" name="phone"></label></div>
						<div class="field--full"><label class="label"><?php esc_html_e( 'Message', 'parts-mall' ); ?><textarea name="message" placeholder="<?php esc_attr_e( 'Tell us if you need branch help, wholesale support, franchise information, product assistance, or a general enquiry.', 'parts-mall' ); ?>"></textarea></label></div>
					</div>
					<div class="cluster">
						<button type="submit" class="btn btn--signal"><?php esc_html_e( 'Send enquiry', 'parts-mall' ); ?></button>
						<div class="form-status" data-form-status role="status" aria-live="polite"></div>
					</div>
				</form>
			</div>
		</div>

		<div class="details-stack">
			<?php foreach ( partsmall_faq_items() as $faq ) : ?>
				<details class="accordion-card" data-reveal>
					<summary><?php echo esc_html( $faq['q'] ); ?></summary>
					<div class="accordion-card__content"><p><?php echo esc_html( $faq['a'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
