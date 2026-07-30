<?php
/**
 * Landing page.
 *
 * This page has one job: take paid-search traffic and route it to the right
 * branch on WhatsApp with as little friction as possible. Everything below
 * the hero exists to answer "are these people real and do they have my part".
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

get_header();

$branches = kms_branch();
?>

<section class="hero">
	<div class="hero__media">
		<picture>
			<source
				media="(min-width: 64em)"
				srcset="<?php echo esc_url( kms_img( 'hero.webp' ) ); ?> 1400w, <?php echo esc_url( kms_img( 'hero@2800.webp' ) ); ?> 2800w"
				sizes="100vw"
			>
			<img
				src="<?php echo esc_url( kms_img( 'hero-portrait.webp' ) ); ?>"
				srcset="<?php echo esc_url( kms_img( 'hero-portrait.webp' ) ); ?> 800w, <?php echo esc_url( kms_img( 'hero-portrait@1600.webp' ) ); ?> 1600w"
				sizes="100vw"
				alt="<?php esc_attr_e( 'A brake disc, a boxed air filter, a drive belt and four spark plugs laid out on a pale concrete counter', 'kms-branch' ); ?>"
				width="1400"
				height="600"
				fetchpriority="high"
				decoding="async"
			>
		</picture>
	</div>

	<div class="hero__inner wrap">
		<div class="hero__content">
			<p class="eyebrow"><?php esc_html_e( 'Korean vehicle parts since 1996', 'kms-branch' ); ?></p>

			<h1 class="display hero__title">
				<?php esc_html_e( 'The part you need, in stock in the south.', 'kms-branch' ); ?>
			</h1>

			<p class="lede hero__lede">
				<?php esc_html_e( 'Two Korean Motor Spares counters, in Lenasia and Vereeniging. Send us the year, the model and the part, and we will tell you there and then whether it is on the shelf.', 'kms-branch' ); ?>
			</p>

			<div class="hero__actions" data-actionbar-anchor>
				<a class="btn btn--wa btn--lg" href="#branches">
					<?php kms_icon( 'whatsapp', array( 'size' => 20 ) ); ?>
					<?php esc_html_e( 'WhatsApp a branch', 'kms-branch' ); ?>
				</a>
				<a class="btn btn--ghost btn--lg" href="#parts">
					<?php esc_html_e( 'See what we carry', 'kms-branch' ); ?>
				</a>
			</div>

			<div class="hero__status">
				<?php foreach ( $branches as $branch ) : ?>
					<p class="hero__status-item">
						<span class="hero__status-name"><?php echo esc_html( $branch['name'] ); ?></span>
						<?php get_template_part( 'template-parts/status', null, array( 'branch' => $branch ) ); ?>
					</p>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<div class="wrap">
	<ul class="makes reveal">
		<li class="makes__label"><?php esc_html_e( 'We carry', 'kms-branch' ); ?></li>
		<?php foreach ( kms_makes() as $i => $make ) : ?>
			<?php if ( $i > 0 ) : ?>
				<li class="makes__sep" aria-hidden="true"></li>
			<?php endif; ?>
			<li class="makes__item"><?php echo esc_html( $make ); ?></li>
		<?php endforeach; ?>
		<li class="makes__note"><?php esc_html_e( 'Every model', 'kms-branch' ); ?></li>
	</ul>
</div>

<section class="section" id="branches">
	<div class="wrap">
		<div class="sectionhead sectionhead--split reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Your branch', 'kms-branch' ); ?></p>
				<h2 class="h2 sectionhead__title"><?php esc_html_e( 'Pick the counter closest to you', 'kms-branch' ); ?></h2>
			</div>
			<p class="muted">
				<?php esc_html_e( 'Both branches carry stock, both answer WhatsApp during trading hours, and both can pull from the wider group if something is not on the shelf.', 'kms-branch' ); ?>
			</p>
		</div>

		<div class="router">
			<?php foreach ( $branches as $branch ) : ?>
				<?php get_template_part( 'template-parts/branch-card', null, array( 'branch' => $branch ) ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section is-surface" id="parts">
	<div class="wrap">
		<div class="sectionhead sectionhead--split reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'What we carry', 'kms-branch' ); ?></p>
				<h2 class="h2 sectionhead__title"><?php esc_html_e( 'Everything that wears out', 'kms-branch' ); ?></h2>
			</div>
			<p class="muted">
				<?php esc_html_e( 'Service and repair parts for Hyundai, Kia, Daewoo and SsangYong. Trade prices, walk in or message ahead.', 'kms-branch' ); ?>
			</p>
		</div>

		<?php get_template_part( 'template-parts/parts-grid', null, array( 'branch' => null ) ); ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="ask">
			<div class="reveal">
				<p class="eyebrow"><?php esc_html_e( 'How it works', 'kms-branch' ); ?></p>
				<h2 class="h2 sectionhead__title" style="margin-bottom:2rem;">
					<?php esc_html_e( 'Three lines on WhatsApp and you have your answer', 'kms-branch' ); ?>
				</h2>

				<ol class="ask__steps">
					<li class="ask__step">
						<p>
							<strong><?php esc_html_e( 'Tell us the car', 'kms-branch' ); ?></strong>
							<?php esc_html_e( 'Make, model and year. An i10 2014 or a Picanto 2019 is plenty to go on.', 'kms-branch' ); ?>
						</p>
					</li>
					<li class="ask__step">
						<p>
							<strong><?php esc_html_e( 'Name the part, or photograph it', 'kms-branch' ); ?></strong>
							<?php esc_html_e( 'A picture of the old one off the car works as well as a part number. Better, usually.', 'kms-branch' ); ?>
						</p>
					</li>
					<li class="ask__step">
						<p>
							<strong><?php esc_html_e( 'We check the shelf and price it', 'kms-branch' ); ?></strong>
							<?php esc_html_e( 'If it is in, come fetch it. If it is not, we say so and tell you when it will be.', 'kms-branch' ); ?>
						</p>
					</li>
				</ol>

				<div class="closer__actions" style="margin-top:0;">
					<?php foreach ( $branches as $branch ) : ?>
						<a class="btn btn--ghost" href="<?php echo esc_url( kms_whatsapp_url( $branch ) ); ?>" rel="noopener" target="_blank">
							<?php kms_icon( 'whatsapp', array( 'size' => 18 ) ); ?>
							<?php
							/* translators: %s: branch name */
							printf( esc_html__( 'Message %s', 'kms-branch' ), esc_html( $branch['name'] ) );
							?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<figure class="ask__photo reveal">
				<img
					src="<?php echo esc_url( kms_img( 'alternator.webp' ) ); ?>"
					srcset="<?php echo esc_url( kms_img( 'alternator.webp' ) ); ?> 700w, <?php echo esc_url( kms_img( 'alternator@1400.webp' ) ); ?> 1400w"
					sizes="(min-width: 58em) 32rem, 92vw"
					alt="<?php esc_attr_e( 'A new alternator held in both hands over a workbench', 'kms-branch' ); ?>"
					width="700"
					height="875"
					loading="lazy"
					decoding="async"
				>
			</figure>
		</div>
	</div>
</section>

<section class="band">
	<img
		class="band__media"
		src="<?php echo esc_url( kms_img( 'street.webp' ) ); ?>"
		srcset="<?php echo esc_url( kms_img( 'street.webp' ) ); ?> 800w, <?php echo esc_url( kms_img( 'street@1600.webp' ) ); ?> 980w"
		sizes="100vw"
		alt="<?php esc_attr_e( 'A Korean Motor Spares shopfront on a South African main road', 'kms-branch' ); ?>"
		width="980"
		height="551"
		loading="lazy"
		decoding="async"
	>
	<div class="band__caption reveal">
		<div class="wrap">
			<p><?php esc_html_e( 'Seventeen Korean Motor Spares counters across South Africa stand behind these two.', 'kms-branch' ); ?></p>
		</div>
	</div>
</section>

<section class="section--tight">
	<div class="wrap">
		<ul class="facts">
			<li class="fact reveal">
				<span class="fact__value tnum">1996</span>
				<span class="fact__label"><?php esc_html_e( 'Supplying Korean parts in South Africa under the same name', 'kms-branch' ); ?></span>
			</li>
			<li class="fact reveal">
				<span class="fact__value tnum">17</span>
				<span class="fact__label"><?php esc_html_e( 'Branches nationwide, so stock can be moved between counters', 'kms-branch' ); ?></span>
			</li>
			<li class="fact reveal">
				<span class="fact__value tnum">4</span>
				<span class="fact__label"><?php esc_html_e( 'Makes covered in depth: Hyundai, Kia, Daewoo, SsangYong', 'kms-branch' ); ?></span>
			</li>
			<li class="fact reveal">
				<span class="fact__value"><?php esc_html_e( 'Mon to Sat', 'kms-branch' ); ?></span>
				<span class="fact__label"><?php esc_html_e( 'Both counters trade six days a week', 'kms-branch' ); ?></span>
			</li>
		</ul>
	</div>
</section>

<section class="section is-ink closer">
	<div class="wrap reveal">
		<p class="eyebrow"><?php esc_html_e( 'Get in touch', 'kms-branch' ); ?></p>
		<h2 class="h2 closer__title"><?php esc_html_e( 'Tell us what you are looking for', 'kms-branch' ); ?></h2>
		<p class="lede">
			<?php esc_html_e( 'Send a message to whichever branch is closer. If we are closed, we pick it up first thing.', 'kms-branch' ); ?>
		</p>
		<div class="closer__actions">
			<?php foreach ( $branches as $branch ) : ?>
				<a class="btn btn--wa btn--lg" href="<?php echo esc_url( kms_whatsapp_url( $branch ) ); ?>" rel="noopener" target="_blank">
					<?php kms_icon( 'whatsapp', array( 'size' => 20 ) ); ?>
					<?php echo esc_html( $branch['name'] ); ?>
					<span class="visually-hidden"><?php esc_html_e( 'on WhatsApp', 'kms-branch' ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
