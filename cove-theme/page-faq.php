<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * Frequently asked questions page.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<!-- Page hero -->
<section class="page-hero">
	<div class="container">
		<span class="eyebrow eyebrow--amber"><?php esc_html_e( 'Questions &amp; answers', 'cove' ); ?></span>
		<h1 class="t-1"><?php esc_html_e( 'Frequently asked questions.', 'cove' ); ?></h1>
		<p class="t-lead"><?php esc_html_e( 'Everything you need to know about buying certified demo and b-stock appliances from COVE.', 'cove' ); ?></p>
	</div>
</section>

<!-- FAQ list -->
<section class="section--tight">
	<div class="container">
		<div class="faq-list" data-reveal>

			<div class="faq-item">
				<details>
					<summary><?php esc_html_e( 'What exactly is b-stock?', 'cove' ); ?></summary>
					<p class="faq-item__answer">
						<?php esc_html_e( 'B-stock refers to appliances that did not complete a standard retail journey. This includes certified demo units that have been used on showroom floors or at exhibitions, open-box returns that were never used at home, and manufacturer overstock. These units leave the factory in full working order and are sold at a discount because they bypassed the standard retail chain.', 'cove' ); ?>
					</p>
				</details>
			</div>

			<div class="faq-item">
				<details>
					<summary><?php esc_html_e( 'What does the grade mean?', 'cove' ); ?></summary>
					<p class="faq-item__answer">
						<?php esc_html_e( 'Every unit we sell is graded A, B or C. Grade A is certified like-new: no cosmetic wear, all accessories present, functionally perfect. Grade B shows minor wear such as light scuffs but is fully functional. Grade C shows visible cosmetic defects that we photograph in full detail &mdash; the appliance works correctly but looks used. All three grades carry a 90-day COVE warranty.', 'cove' ); ?>
					</p>
				</details>
			</div>

			<div class="faq-item">
				<details>
					<summary><?php esc_html_e( 'Do COVE appliances come with a warranty?', 'cove' ); ?></summary>
					<p class="faq-item__answer">
						<?php esc_html_e( 'Yes. Every unit sold by COVE carries a 90-day COVE warranty regardless of grade. This covers functional defects and mechanical failures. It does not cover accidental damage or misuse. Grade A units from participating brands may also carry a residual manufacturer warranty &mdash; this is noted on the individual product listing where applicable.', 'cove' ); ?>
					</p>
				</details>
			</div>

			<div class="faq-item">
				<details>
					<summary><?php esc_html_e( 'What is your returns policy?', 'cove' ); ?></summary>
					<p class="faq-item__answer">
						<?php esc_html_e( 'You have 30 days from delivery to return any item for any reason. The unit must be in the same condition as received. We arrange collection at no charge if the return is due to a defect or a significant mismatch between the listing and the product. For change-of-mind returns, a collection fee applies. Refunds are processed within 5 business days of the unit arriving back at our warehouse.', 'cove' ); ?>
					</p>
				</details>
			</div>

			<div class="faq-item">
				<details>
					<summary><?php esc_html_e( 'How do you inspect and grade each unit?', 'cove' ); ?></summary>
					<p class="faq-item__answer">
						<?php esc_html_e( 'Each unit goes through a structured inspection before listing: we test all functions, check and photograph all surfaces, verify accessories, and clean and sanitise the appliance. Grade decisions are made by trained inspectors against a written rubric. Photographs are taken under consistent lighting so cosmetic condition is accurately represented in the listing.', 'cove' ); ?>
					</p>
				</details>
			</div>

			<div class="faq-item">
				<details>
					<summary><?php esc_html_e( 'Do you ship across South Africa?', 'cove' ); ?></summary>
					<p class="faq-item__answer">
						<?php esc_html_e( 'Yes. We ship nationwide. Standard delivery takes 3 to 5 business days for main centres and 5 to 7 business days for outlying areas. Appliances requiring specialised handling (large fridges, built-in ovens) are delivered by a dedicated appliance courier with two-person delivery to your door. Free shipping applies on all orders over R800.', 'cove' ); ?>
					</p>
				</details>
			</div>

			<div class="faq-item">
				<details>
					<summary><?php esc_html_e( 'Can I collect in person?', 'cove' ); ?></summary>
					<p class="faq-item__answer">
						<?php esc_html_e( 'Yes. Our warehouse is open for collections Monday to Friday, 09:00 to 17:00. Select "Collect" at checkout to waive the delivery fee. You will receive a ready-for-collection notification via email and SMS when your order has been picked and packed. Bring your order confirmation and a valid ID.', 'cove' ); ?>
					</p>
				</details>
			</div>

		</div><!-- .faq-list -->

		<div style="text-align:center;margin-top:var(--s-8)" data-reveal>
			<p class="t-lead" style="margin-bottom:var(--s-5)"><?php esc_html_e( 'Still have a question?', 'cove' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
				<?php esc_html_e( 'Contact us', 'cove' ); ?>
			</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
