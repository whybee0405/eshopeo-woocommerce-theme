<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Contact page with AJAX form.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<!-- Page hero -->
<section class="page-hero">
	<div class="container">
		<span class="eyebrow eyebrow--amber"><?php esc_html_e( 'Get in touch', 'cove' ); ?></span>
		<h1 class="t-1"><?php esc_html_e( 'We are here to help.', 'cove' ); ?></h1>
		<p class="t-lead"><?php esc_html_e( 'Questions about a product, an order, or the grade system? Send us a message and we will get back to you within one business day.', 'cove' ); ?></p>
	</div>
</section>

<!-- Contact grid -->
<section class="section">
	<div class="container">
		<div class="contact-grid" data-reveal>

			<!-- Contact form -->
			<div>
				<h2 class="t-3" style="margin-bottom:var(--s-5)"><?php esc_html_e( 'Send a message', 'cove' ); ?></h2>
				<form class="stack" data-contact-form novalidate>
					<?php wp_nonce_field( 'cove_nonce', 'contact_nonce' ); ?>

					<div class="field">
						<label class="label" for="contact-name"><?php esc_html_e( 'Your name', 'cove' ); ?> <span aria-hidden="true" style="color:var(--amber)">*</span></label>
						<input class="input" type="text" id="contact-name" name="name" autocomplete="name" required placeholder="<?php esc_attr_e( 'Jane Smith', 'cove' ); ?>">
					</div>

					<div class="field">
						<label class="label" for="contact-email"><?php esc_html_e( 'Email address', 'cove' ); ?> <span aria-hidden="true" style="color:var(--amber)">*</span></label>
						<input class="input" type="email" id="contact-email" name="email" autocomplete="email" required placeholder="<?php esc_attr_e( 'jane@example.com', 'cove' ); ?>">
					</div>

					<div class="field">
						<label class="label" for="contact-subject"><?php esc_html_e( 'Subject', 'cove' ); ?></label>
						<select class="select" id="contact-subject" name="subject">
							<option value=""><?php esc_html_e( 'Select a topic', 'cove' ); ?></option>
							<option value="order"><?php esc_html_e( 'Order enquiry', 'cove' ); ?></option>
							<option value="product"><?php esc_html_e( 'Product question', 'cove' ); ?></option>
							<option value="returns"><?php esc_html_e( 'Returns &amp; warranty', 'cove' ); ?></option>
							<option value="grades"><?php esc_html_e( 'Grade system', 'cove' ); ?></option>
							<option value="other"><?php esc_html_e( 'Something else', 'cove' ); ?></option>
						</select>
					</div>

					<div class="field">
						<label class="label" for="contact-message"><?php esc_html_e( 'Message', 'cove' ); ?> <span aria-hidden="true" style="color:var(--amber)">*</span></label>
						<textarea class="textarea input" id="contact-message" name="message" rows="6" required placeholder="<?php esc_attr_e( 'Tell us how we can help&hellip;', 'cove' ); ?>"></textarea>
					</div>

					<div class="contact-form-status" role="status" aria-live="polite" style="display:none"></div>

					<div>
						<button class="btn btn--primary" type="submit">
							<?php esc_html_e( 'Send message', 'cove' ); ?>
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
						</button>
					</div>
				</form>
			</div>

			<!-- Contact details -->
			<div>
				<h2 class="t-3" style="margin-bottom:var(--s-5)"><?php esc_html_e( 'Contact details', 'cove' ); ?></h2>
				<div class="stack">

					<div style="background:#fff;border:1.5px solid var(--line);border-radius:var(--r-l);padding:var(--s-5)">
						<div class="cluster" style="margin-bottom:var(--s-3)">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="color:var(--amber);flex-shrink:0"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							<span class="t-3" style="font-size:0.9rem"><?php esc_html_e( 'Email', 'cove' ); ?></span>
						</div>
						<a href="mailto:hello@cove.co.za" class="link-arrow" style="font-size:1rem">hello@cove.co.za</a>
					</div>

					<div style="background:#fff;border:1.5px solid var(--line);border-radius:var(--r-l);padding:var(--s-5)">
						<div class="cluster" style="margin-bottom:var(--s-3)">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="color:var(--amber);flex-shrink:0"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.64A2 2 0 012 .99h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91A16 16 0 0015.1 17.9l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
							<span class="t-3" style="font-size:0.9rem"><?php esc_html_e( 'Phone', 'cove' ); ?></span>
						</div>
						<a href="tel:+27110000000" class="link-arrow" style="font-size:1rem">+27 11 000 0000</a>
					</div>

					<div style="background:#fff;border:1.5px solid var(--line);border-radius:var(--r-l);padding:var(--s-5)">
						<div class="cluster" style="margin-bottom:var(--s-3)">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="color:var(--amber);flex-shrink:0"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
							<span class="t-3" style="font-size:0.9rem"><?php esc_html_e( 'Business hours', 'cove' ); ?></span>
						</div>
						<p style="font-size:0.9rem;color:var(--muted);line-height:1.7">
							<?php esc_html_e( 'Monday &ndash; Friday', 'cove' ); ?><br>
							<strong style="color:var(--slate)"><?php esc_html_e( '08:00 &ndash; 17:00 SAST', 'cove' ); ?></strong>
						</p>
						<p style="font-size:0.82rem;color:var(--muted);margin-top:var(--s-2)">
							<?php esc_html_e( 'We reply within one business day.', 'cove' ); ?>
						</p>
					</div>

				</div><!-- .stack -->
			</div>

		</div><!-- .contact-grid -->
	</div>
</section>

<?php get_footer(); ?>
