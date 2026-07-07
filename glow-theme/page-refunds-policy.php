<?php
/**
 * Refunds Policy - served at /refunds-policy
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
			<p class="eyebrow"><?php esc_html_e( 'Returns and refunds', 'glow-glow' ); ?></p>
			<h1 class="t-hero"><?php esc_html_e( 'Refunds Policy', 'glow-glow' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'A practical policy for unopened products, damaged parcels, incorrect items and skin reactions.', 'glow-glow' ); ?></p>
		</header>
	</div>

	<section class="section-tight">
		<div class="container">
			<div class="prose" data-reveal>
				<p><strong><?php esc_html_e( 'Last updated:', 'glow-glow' ); ?></strong> <?php esc_html_e( '7 July 2026', 'glow-glow' ); ?></p>
				<p><?php esc_html_e( 'This policy applies to purchases made from Glow in South Africa. It is designed around skincare hygiene, fair customer treatment and South African consumer principles, including online shopping rights under the Electronic Communications and Transactions Act and quality rights under the Consumer Protection Act.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Unopened products', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'You may return unopened, unused products in their original packaging within 30 days of delivery. Once we receive and inspect the product, we will refund the product price to the original payment method or issue store credit if you prefer.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Online cooling-off returns', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'If your purchase qualifies for a statutory online cooling-off return, contact us within 7 days of receiving the goods. Products must be returned unused, unopened and in a resaleable condition unless the law gives you a different right because the item is defective, unsafe or incorrectly supplied.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Opened skincare and hygiene', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'For hygiene and safety reasons, opened skincare cannot usually be returned simply because you changed your mind. We cannot resell opened cosmetic products. This does not limit your rights if a product is defective, unsafe, incorrectly supplied or covered by our skin reaction process below.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Skin reactions', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Skin is personal, and even well-formulated products can disagree with someone. If you experience a genuine reaction, contact us within 14 days of delivery. We may ask for the order number, product name, batch number, photos and how the product was used so we can assess the issue and report it to the brand where needed.', 'glow-glow' ); ?></p>
				<p><?php esc_html_e( 'Where appropriate, we may offer a refund, exchange, store credit or routine adjustment advice. We reserve the right to decline reaction claims that appear unrelated to the product, inconsistent with the usage instructions or submitted without enough information to assess.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Damaged, defective or incorrect items', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'If your parcel arrives damaged, defective, leaking, expired or different from what you ordered, contact us within 7 days of delivery. Include photos of the product, packaging, shipping label and batch number where possible. We will arrange a replacement, refund, repair where appropriate, or collection at our cost.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Return shipping', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'For change-of-mind returns, return courier costs are usually for your account unless required otherwise by law. For incorrect, damaged or defective products, Glow covers reasonable return or collection costs.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'Refund timing', 'glow-glow' ); ?></h2>
				<p><?php esc_html_e( 'Refunds are processed after inspection or claim approval. Bank and payment-provider processing times vary, but most refunds reflect within 5 to 10 business days after release.', 'glow-glow' ); ?></p>

				<h2><?php esc_html_e( 'How to start a return', 'glow-glow' ); ?></h2>
				<p><?php echo wp_kses_post( sprintf( __( 'Send your order number and reason through the <a href="%s">contact page</a>. Keep the product and packaging until we confirm the next step.', 'glow-glow' ), esc_url( home_url( '/contact/' ) ) ) ); ?></p>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
