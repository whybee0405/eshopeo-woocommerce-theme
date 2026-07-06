<?php
/**
 * Template Name: FAQ
 *
 * @package KBAP
 */

get_header();
?>
<section class="section">
	<div class="container">
		<p class="eyebrow"><?php esc_html_e( 'FAQ', 'kbap' ); ?></p>
		<h1 class="t-1"><?php esc_html_e( 'Questions before you book or buy.', 'kbap' ); ?></h1>
		<div class="faq-list" style="margin-top:2rem">
			<?php foreach ( kbap_faq_items() as $index => $item ) : ?>
				<details class="faq-item reveal" <?php echo 0 === $index ? 'open' : ''; ?>>
					<summary><?php echo esc_html( $item['q'] ); ?></summary>
					<div class="faq-body"><?php echo esc_html( $item['a'] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
