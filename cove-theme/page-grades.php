<?php
/**
 * Template Name: Grades
 * Template Post Type: page
 *
 * Grade A/B/C explanation page.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<!-- Page hero -->
<section class="page-hero">
	<div class="container">
		<span class="eyebrow eyebrow--amber"><?php esc_html_e( 'The grade system', 'cove' ); ?></span>
		<h1 class="t-1"><?php esc_html_e( 'Every unit graded. Every time.', 'cove' ); ?></h1>
		<p class="t-lead"><?php esc_html_e( 'We inspect, photograph and categorise every appliance before it reaches you. No surprises, no vague descriptions &mdash; just an honest grade.', 'cove' ); ?></p>
	</div>
</section>

<!-- Grade cards -->
<section class="section">
	<div class="container">
		<div class="grades-grid">

			<!-- Grade A -->
			<div class="grade-card grade-card--a" data-reveal>
				<div class="grade-card__letter">A</div>
				<h2 class="t-3"><?php esc_html_e( 'Grade A', 'cove' ); ?></h2>
				<p class="eyebrow" style="margin-top:var(--s-2)"><?php esc_html_e( 'Certified like-new', 'cove' ); ?></p>
				<p style="margin-top:var(--s-4);color:var(--muted);font-size:0.9rem;line-height:1.75">
					<?php esc_html_e( 'Grade A units are certified demo or open-box appliances that have never been used in a home. They come from store floors, brand roadshows and manufacturer samples. Cosmetically perfect, fully functional &mdash; essentially brand new at a fraction of the price.', 'cove' ); ?>
				</p>
				<ul class="grade-card__checks">
					<li class="grade-card__check"><?php esc_html_e( 'Zero signs of use', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'All accessories included', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( '90-day COVE warranty', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'Full function test passed', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'Original or clean packaging', 'cove' ); ?></li>
				</ul>
				<p class="t-mono" style="color:var(--grade-a);font-size:0.85rem;margin-bottom:var(--s-5)">
					<?php esc_html_e( 'Save up to 35% vs. retail', 'cove' ); ?>
				</p>
				<a class="btn btn--outline-amber" href="<?php echo esc_url( add_query_arg( 'condition', 'grade-a', function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ) ); ?>">
					<?php esc_html_e( 'Browse Grade A', 'cove' ); ?>
				</a>
			</div>

			<!-- Grade B -->
			<div class="grade-card grade-card--b" data-reveal>
				<div class="grade-card__letter">B</div>
				<h2 class="t-3"><?php esc_html_e( 'Grade B', 'cove' ); ?></h2>
				<p class="eyebrow" style="margin-top:var(--s-2)"><?php esc_html_e( 'Excellent refurbished', 'cove' ); ?></p>
				<p style="margin-top:var(--s-4);color:var(--muted);font-size:0.9rem;line-height:1.75">
					<?php esc_html_e( 'Grade B units have been lightly used or professionally refurbished. They may show minor cosmetic wear &mdash; a faint scuff, a light surface mark &mdash; but all mechanical and electrical functions are in full working order after our inspection.', 'cove' ); ?>
				</p>
				<ul class="grade-card__checks">
					<li class="grade-card__check"><?php esc_html_e( 'Minor cosmetic wear only', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'All key functions tested', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( '90-day COVE warranty', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'Cleaned &amp; sanitised', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'Photo evidence in listing', 'cove' ); ?></li>
				</ul>
				<p class="t-mono" style="color:var(--grade-b);font-size:0.85rem;margin-bottom:var(--s-5)">
					<?php esc_html_e( 'Save up to 50% vs. retail', 'cove' ); ?>
				</p>
				<a class="btn btn--outline-amber" href="<?php echo esc_url( add_query_arg( 'condition', 'grade-b', function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ) ); ?>">
					<?php esc_html_e( 'Browse Grade B', 'cove' ); ?>
				</a>
			</div>

			<!-- Grade C -->
			<div class="grade-card grade-card--c" data-reveal>
				<div class="grade-card__letter">C</div>
				<h2 class="t-3"><?php esc_html_e( 'Grade C', 'cove' ); ?></h2>
				<p class="eyebrow" style="margin-top:var(--s-2)"><?php esc_html_e( 'Fully functional, visible wear', 'cove' ); ?></p>
				<p style="margin-top:var(--s-4);color:var(--muted);font-size:0.9rem;line-height:1.75">
					<?php esc_html_e( 'Grade C units have visible cosmetic wear &mdash; scratches, dents or discolouration &mdash; but work exactly as intended. Every unit is photographed with the defects clearly shown. What you see is what you get, honestly priced.', 'cove' ); ?>
				</p>
				<ul class="grade-card__checks">
					<li class="grade-card__check"><?php esc_html_e( 'Clearly photographed defects', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'Full mechanical function', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( '90-day COVE warranty', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'Deep-cleaned before dispatch', 'cove' ); ?></li>
					<li class="grade-card__check"><?php esc_html_e( 'No hidden damage', 'cove' ); ?></li>
				</ul>
				<p class="t-mono" style="color:var(--sand);font-size:0.85rem;margin-bottom:var(--s-5)">
					<?php esc_html_e( 'Save up to 65% vs. retail', 'cove' ); ?>
				</p>
				<a class="btn btn--outline-amber" href="<?php echo esc_url( add_query_arg( 'condition', 'grade-c', function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ) ); ?>">
					<?php esc_html_e( 'Browse Grade C', 'cove' ); ?>
				</a>
			</div>

		</div><!-- .grades-grid -->

		<!-- Bottom assurance row -->
		<div class="surface-slate" style="border-radius:var(--r-l);padding:var(--s-7) var(--s-8);margin-top:var(--s-9);text-align:center;" data-reveal>
			<span class="eyebrow eyebrow--amber" style="justify-content:center;margin-bottom:var(--s-4)"><?php esc_html_e( 'Our promise', 'cove' ); ?></span>
			<h2 class="t-2" style="color:#fff;margin-bottom:var(--s-5)"><?php esc_html_e( 'Every unit. Every time.', 'cove' ); ?></h2>
			<p class="t-lead" style="max-width:560px;margin-inline:auto;margin-bottom:var(--s-6)">
				<?php esc_html_e( 'Every appliance we sell is inspected, photographed and graded by our team before it is listed. If it does not meet the grade, it does not ship. Every unit comes with a 90-day COVE warranty and 30-day returns &mdash; regardless of grade.', 'cove' ); ?>
			</p>
			<div class="cluster" style="justify-content:center">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>">
					<?php esc_html_e( 'Shop all appliances', 'cove' ); ?>
				</a>
				<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/faq' ) ); ?>">
					<?php esc_html_e( 'Read the FAQ', 'cove' ); ?>
				</a>
			</div>
		</div>

	</div><!-- .container -->
</section>

<?php get_footer(); ?>
