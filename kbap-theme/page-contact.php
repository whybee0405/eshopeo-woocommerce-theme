<?php
/**
 * Template Name: Contact
 *
 * @package KBAP
 */

get_header();
?>
<section class="section section--cream">
	<div class="container">
		<div class="section-head reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Contact', 'kbap' ); ?></p>
				<h1 class="t-1"><?php esc_html_e( 'Tell us what table you are planning.', 'kbap' ); ?></h1>
			</div>
			<p class="lead"><?php esc_html_e( 'Use this form for catering quotes, product questions, markets, kimchi enquiries, or menu planning.', 'kbap' ); ?></p>
		</div>
		<?php get_template_part( 'template-parts/enquiry-form', null, array( 'topic' => 'general' ) ); ?>
	</div>
</section>
<?php get_footer(); ?>
