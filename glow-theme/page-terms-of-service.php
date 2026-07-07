<?php
/**
 * Terms of Service - served at /terms-of-service
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
			<p class="eyebrow"><?php esc_html_e( 'Using Glow', 'glow-glow' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'Terms of Service', 'glow-glow' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'The rules for browsing, buying, paying, receiving advice and using the Glow website.', 'glow-glow' ); ?></p>
		</header>
	</div>

	<section class="section-tight">
		<div class="container">
			<div class="prose" data-reveal>
				<p><strong><?php esc_html_e( 'Last updated:', 'glow-glow' ); ?></strong> <?php esc_html_e( '7 July 2026', 'glow-glow' ); ?></p>
				<p><?php esc_html_e( 'These terms apply when you use the Glow website, create an account, place an order, ask for skincare guidance or interact with our services. By using the website, you agree to these terms.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'About Glow', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Glow is a South African ecommerce brand selling curated Korean skincare. Products are sold for personal use unless we agree otherwise in writing.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Product information', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'We work to keep product descriptions, ingredient notes, prices, stock status and images accurate. Skincare packaging, formulas and ingredient lists can change, so always check the product packaging before use, especially if you have allergies, sensitivities, are pregnant, are using prescription treatments or have a medical skin condition.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Skincare guidance is not medical advice', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Our content, routine guidance, AI search and support messages are educational ecommerce guidance. They are not medical advice, diagnosis or treatment. If you have a skin condition, severe reaction, persistent irritation or medical concern, speak to a qualified healthcare professional.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Orders and acceptance', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Placing an order is an offer to buy. We accept the order when payment is confirmed and we dispatch or otherwise confirm acceptance. We may cancel or refund orders where stock is unavailable, payment fails, information is incorrect, fraud is suspected or a pricing or listing error is obvious.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Pricing and payment', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Prices are shown in South African rand unless stated otherwise. Delivery fees, promotions and taxes are shown during checkout where applicable. Payment must clear before dispatch. Payment providers may apply their own terms.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Delivery', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Delivery times are estimates, not guarantees. We are not responsible for delays outside our reasonable control, including courier delays, incorrect delivery details, weather disruption, strikes, customs or payment verification delays. Risk in the products passes to you when the order is delivered to the address you provided.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Returns and refunds', 'glow-glow' ); ?></h2>
				<p><?php echo wp_kses_post( sprintf( __( 'Returns, refunds, damaged products and reaction claims are handled under our <a href="%s">Refunds Policy</a>.', 'glow-glow' ), esc_url( home_url( '/refunds-policy/' ) ) ) ); ?></p>

				<h2><?php esc_html_e( 'Accounts', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'You are responsible for keeping account login details secure and for activity under your account. Tell us promptly if you suspect unauthorised access.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Acceptable use', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'You may not misuse the website, attempt to break security, scrape content at scale, upload malicious code, interfere with checkout, impersonate someone else, submit false claims or use the site for unlawful activity.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Intellectual property', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'The Glow name, design, copy, photography, product curation, graphics and website content belong to Glow or our licensors unless stated otherwise. You may not copy or reuse them commercially without written permission.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Limitation of liability', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'To the extent allowed by law, Glow is not liable for indirect, incidental or consequential loss arising from use of the website or products. Nothing in these terms limits rights that cannot legally be limited, including applicable consumer rights.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Changes to these terms', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'We may update these terms when our store, services or legal requirements change. The updated version applies from the date published on this page.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Contact', 'glow-glow' ); ?></h2>
				<p><?php echo wp_kses_post( sprintf( __( 'Questions about these terms can be sent through the <a href="%s">contact page</a>.', 'glow-glow' ), esc_url( home_url( '/contact/' ) ) ) ); ?></p>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
