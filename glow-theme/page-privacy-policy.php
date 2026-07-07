<?php
/**
 * Privacy Policy - served at /privacy-policy
 *
 * @package Glow_KBeauty
 */

get_header();

if ( glow_is_elementor_page() ) {
	echo '<main id="main">';
	while ( have_posts() ) { the_post(); the_content(); }
	echo '</main>';
	get_footer();
	return;
}
?>

<main id="main">

	<div class="container">
		<header class="page-hero">
			<p class="eyebrow"><?php esc_html_e( 'Your information', 'glow-glow' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'Privacy Policy', 'glow-glow' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'How Glow collects, uses, protects and shares personal information when you browse, shop, ask for advice or create an account.', 'glow-glow' ); ?></p>
		</header>
	</div>

	<section class="section-tight">
		<div class="container">
			<div class="prose" data-reveal>
				<p><strong><?php esc_html_e( 'Last updated:', 'glow-glow' ); ?></strong> <?php esc_html_e( '7 July 2026', 'glow-glow' ); ?></p>
				<p><?php esc_html_e( 'Glow is a South African ecommerce brand. This policy is written with South African privacy principles in mind, including the Protection of Personal Information Act, 2013 (POPIA). It is intended to explain our day-to-day handling of customer information in plain language.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Information we collect', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'We collect the information needed to run an online skincare store: your name, email address, phone number, billing and delivery address, order history, account login details, payment status, support messages, product reviews and any skincare preferences you choose to share.', 'glow-glow' ); ?></p>
				<p><?php esc_html_e( 'We also collect basic technical information such as IP address, browser type, device information, pages viewed, referring links and cookie identifiers so the site can work properly, stay secure and help us understand what shoppers need.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'How we use it', 'glow-glow' ); ?></h2>
				<ul>
					<li><?php esc_html_e( 'To process orders, payments, delivery, returns and customer service requests.', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'To keep your account, cart, wishlist and order history working.', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'To answer skincare questions and make product guidance more relevant when you ask us for advice.', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'To send service emails such as order confirmations, delivery updates, password resets and refund notices.', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'To send marketing only where you have subscribed or where the law allows us to contact existing customers about related products. You can unsubscribe at any time.', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'To prevent fraud, secure the website, troubleshoot errors and improve the shopping experience.', 'glow-glow' ); ?></li>
				</ul>

				<h2><?php esc_html_e( 'Payments and delivery partners', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Glow does not store full card numbers. Payments are handled by payment providers such as PayFast, card networks, banks or other checkout providers enabled on the site. Delivery information is shared with couriers so they can deliver your order and contact you about the parcel.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Cookies', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'We use cookies and similar technologies for essential ecommerce functions such as carts, checkout, login, security and remembering preferences. We may also use analytics or marketing cookies to understand site performance and improve campaigns. You can control cookies in your browser, but blocking essential cookies may break checkout or account features.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'When we share information', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'We share personal information only where needed to operate the store, comply with the law, protect our rights or provide a service you requested. This may include hosting providers, WooCommerce extensions, email providers, payment processors, fraud-prevention tools, couriers, professional advisers and regulators where required.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'How long we keep it', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'We keep information for as long as needed for the purpose it was collected, including order fulfilment, accounting, tax, warranty, returns, fraud prevention, customer support and legal record-keeping. When we no longer need it, we delete, anonymise or securely restrict it.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Your choices and rights', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'You can ask us to confirm what personal information we hold about you, correct inaccurate information, object to certain processing, unsubscribe from marketing or request deletion where we are not required to keep the information for legal or operational reasons.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Security', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'We use reasonable technical and organisational safeguards to protect personal information. No online system is perfect, but we limit access, use reputable service providers and monitor the site for abuse or unauthorised activity.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Contact', 'glow-glow' ); ?></h2>
				<p><?php echo wp_kses_post( sprintf( __( 'For privacy questions or data requests, contact us through the <a href="%s">contact page</a>.', 'glow-glow' ), esc_url( home_url( '/contact/' ) ) ) ); ?></p>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
