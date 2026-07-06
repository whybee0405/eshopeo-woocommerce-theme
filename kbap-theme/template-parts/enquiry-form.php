<?php
/**
 * Enquiry form partial.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;
$topic = isset( $args['topic'] ) ? sanitize_text_field( $args['topic'] ) : 'catering';
?>
<form class="form-panel reveal" data-kbap-form>
	<input type="hidden" name="topic" value="<?php echo esc_attr( $topic ); ?>">
	<div class="form-grid">
		<div class="field">
			<label for="kbap-name"><?php esc_html_e( 'Name', 'kbap' ); ?></label>
			<input id="kbap-name" name="name" type="text" autocomplete="name" required>
		</div>
		<div class="field">
			<label for="kbap-email"><?php esc_html_e( 'Email', 'kbap' ); ?></label>
			<input id="kbap-email" name="email" type="email" autocomplete="email" required>
		</div>
		<div class="field">
			<label for="kbap-kind"><?php esc_html_e( 'Topic', 'kbap' ); ?></label>
			<select id="kbap-kind" name="kind">
				<option value="catering"><?php esc_html_e( 'Catering quote', 'kbap' ); ?></option>
				<option value="menu"><?php esc_html_e( 'Menu question', 'kbap' ); ?></option>
				<option value="kimchi"><?php esc_html_e( 'K-BAP Kimchi', 'kbap' ); ?></option>
				<option value="market"><?php esc_html_e( 'Markets and stockists', 'kbap' ); ?></option>
			</select>
		</div>
		<div class="field">
			<label for="kbap-guests"><?php esc_html_e( 'Guests or quantity', 'kbap' ); ?></label>
			<input id="kbap-guests" name="guests" type="text" placeholder="<?php esc_attr_e( 'Example: 40 guests', 'kbap' ); ?>">
		</div>
		<div class="field field--full">
			<label for="kbap-message"><?php esc_html_e( 'Message', 'kbap' ); ?></label>
			<textarea id="kbap-message" name="message" rows="6" required placeholder="<?php esc_attr_e( 'Date, location, event type, favourite dishes, dietary needs...', 'kbap' ); ?>"></textarea>
		</div>
	</div>
	<p class="form-note" data-form-note aria-live="polite"></p>
	<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Send enquiry', 'kbap' ); ?></button>
</form>
