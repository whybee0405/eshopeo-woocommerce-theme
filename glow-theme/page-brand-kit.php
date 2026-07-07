<?php
/**
 * Brand Kit - served at /brand-kit
 *
 * WordPress uses page-{slug}.php automatically for any page whose slug matches.
 * No manual template assignment required. Publish a page with slug "brand-kit".
 *
 * @package GLOW
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	foreach ( (array) wp_styles()->queue as $h ) {
		wp_dequeue_style( $h );
	}
	foreach ( (array) wp_scripts()->queue as $h ) {
		wp_dequeue_script( $h );
	}
}, 100 );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php esc_html_e( 'GLOW Brand Kit v2', 'glow-glow' ); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:wght@400;500;600;700&family=Spline+Sans+Mono:wght@400;500&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
	<style>
		:root {
			--rice: #F7F4EE;
			--ivory: #FBF8F2;
			--cream: #EEE8DC;
			--sage-soft: #DDE8DF;
			--sage: #6F8A78;
			--sage-deep: #4F6F5B;
			--ink: #252922;
			--muted: #72786D;
			--line: #DED8CC;
			--yuja: #F2B63C;
			--font-body: "Schibsted Grotesk", "Helvetica Neue", Arial, sans-serif;
			--font-mono: "Spline Sans Mono", SFMono-Regular, Consolas, monospace;
		}

		* { box-sizing: border-box; }
		html { scroll-behavior: smooth; }
		body {
			margin: 0;
			font-family: var(--font-body);
			color: var(--ink);
			background: var(--rice);
			-webkit-font-smoothing: antialiased;
			line-height: 1.62;
		}

		a { color: inherit; }
		::selection { background: var(--yuja); color: var(--ink); }

		.kit-shell { overflow: hidden; }
		.kit-nav {
			position: sticky;
			top: 0;
			z-index: 20;
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 24px;
			padding: 16px clamp(20px, 4vw, 56px);
			background: color-mix(in srgb, var(--ivory) 92%, transparent);
			backdrop-filter: blur(18px);
			border-bottom: 1px solid var(--line);
		}

		.wordmark {
			font-weight: 700;
			letter-spacing: 0.22em;
			font-size: 1rem;
		}
		.wordmark span { color: var(--yuja); }

		.kit-nav__links {
			display: flex;
			flex-wrap: wrap;
			gap: 6px 18px;
			font-family: var(--font-mono);
			font-size: 0.72rem;
			color: var(--muted);
			text-transform: uppercase;
			letter-spacing: 0.08em;
		}
		.kit-nav__links a { text-decoration: none; }
		.kit-nav__links a:hover { color: var(--ink); }

		.hero {
			min-height: 86svh;
			display: grid;
			align-items: center;
			padding: clamp(76px, 10vw, 132px) clamp(20px, 5vw, 80px);
			background:
				linear-gradient(90deg, var(--ivory) 0%, color-mix(in srgb, var(--ivory) 82%, transparent) 44%, color-mix(in srgb, var(--ivory) 18%, transparent) 100%),
				url("<?php echo esc_url( get_template_directory_uri() . '/images/hero/hero-korean-beauty.png' ); ?>") right center / cover no-repeat;
		}

		.hero__inner { max-width: 760px; }
		.kicker {
			font-family: var(--font-mono);
			font-size: 0.75rem;
			color: var(--sage-deep);
			letter-spacing: 0.12em;
			text-transform: uppercase;
			margin: 0 0 22px;
		}
		h1, h2, h3, p { margin-top: 0; }
		h1 {
			font-size: clamp(3.2rem, 8vw, 7.8rem);
			line-height: 0.96;
			letter-spacing: -0.03em;
			max-width: 8.4em;
			margin-bottom: 28px;
		}
		h1 span { color: var(--yuja); }
		.hero__copy {
			max-width: 58ch;
			font-size: clamp(1.05rem, 1.5vw, 1.26rem);
			color: color-mix(in srgb, var(--ink) 78%, var(--muted));
		}

		.section {
			padding: clamp(70px, 9vw, 128px) clamp(20px, 5vw, 80px);
			border-top: 1px solid var(--line);
		}
		.section--ivory { background: var(--ivory); }
		.section--sage { background: var(--sage-soft); }
		.section__head {
			display: grid;
			grid-template-columns: minmax(0, 0.62fr) minmax(0, 1fr);
			gap: clamp(24px, 5vw, 72px);
			align-items: start;
			margin-bottom: clamp(34px, 5vw, 64px);
		}
		h2 {
			font-size: clamp(2.1rem, 4vw, 4.7rem);
			line-height: 1.02;
			letter-spacing: -0.025em;
			margin-bottom: 0;
		}
		.section__intro {
			max-width: 62ch;
			color: var(--muted);
			font-size: 1.04rem;
		}

		.grid {
			display: grid;
			grid-template-columns: repeat(3, minmax(0, 1fr));
			gap: 1px;
			background: var(--line);
			border: 1px solid var(--line);
		}
		.tile {
			background: var(--ivory);
			padding: clamp(24px, 3vw, 42px);
			min-height: 220px;
		}
		.tile--cream { background: var(--cream); }
		.tile--sage { background: var(--sage-soft); }
		.tile__no {
			display: block;
			font-family: var(--font-mono);
			color: var(--sage-deep);
			font-size: 0.74rem;
			margin-bottom: 32px;
		}
		.tile h3 {
			font-size: clamp(1.18rem, 1.6vw, 1.55rem);
			line-height: 1.15;
			margin-bottom: 12px;
		}
		.tile p { color: var(--muted); margin: 0; }

		.palette {
			display: grid;
			grid-template-columns: repeat(5, minmax(0, 1fr));
			border: 1px solid var(--line);
		}
		.swatch { min-height: 280px; display: flex; flex-direction: column; justify-content: flex-end; padding: 20px; }
		.swatch strong { display: block; }
		.swatch code { font-family: var(--font-mono); font-size: 0.72rem; }
		.swatch--rice { background: var(--rice); }
		.swatch--ivory { background: var(--ivory); }
		.swatch--cream { background: var(--cream); }
		.swatch--sage { background: var(--sage-soft); }
		.swatch--yuja { background: var(--yuja); }

		.logo-board {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 1px;
			background: var(--line);
			border: 1px solid var(--line);
		}
		.logo-panel {
			background: var(--ivory);
			min-height: 360px;
			display: grid;
			place-items: center;
			padding: 40px;
		}
		.logo-panel--dark { background: var(--ink); color: var(--rice); }
		.big-wordmark {
			font-size: clamp(2.8rem, 8vw, 8rem);
			font-weight: 700;
			letter-spacing: 0.2em;
			line-height: 1;
		}
		.big-wordmark span { color: var(--yuja); }
		.o-system {
			display: grid;
			grid-template-columns: repeat(4, 72px);
			gap: 16px;
			justify-content: center;
		}
		.o-mark {
			width: 72px;
			aspect-ratio: 1;
			border-radius: 50%;
			border: 2px solid var(--ink);
			position: relative;
			background: var(--ivory);
		}
		.o-mark::after {
			content: "";
			position: absolute;
			inset: 17px;
			border-radius: 50%;
			border: 2px solid var(--yuja);
		}
		.o-mark:nth-child(2)::after { inset: 12px 20px 20px 12px; }
		.o-mark:nth-child(3) { background: var(--yuja); }
		.o-mark:nth-child(4)::before {
			content: "";
			position: absolute;
			inset: 22px 13px 13px 22px;
			border-radius: 50%;
			background: var(--sage-soft);
		}

		.copy-list {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 1px;
			background: var(--line);
			border: 1px solid var(--line);
		}
		.copy-list > div { background: var(--ivory); padding: clamp(24px, 3vw, 42px); }
		.copy-list ul { margin: 0; padding-left: 1.1em; color: var(--muted); }
		.copy-list li + li { margin-top: 0.55em; }

		.footer-note {
			padding: 44px clamp(20px, 5vw, 80px);
			background: var(--ink);
			color: var(--rice);
			display: flex;
			justify-content: space-between;
			gap: 24px;
			flex-wrap: wrap;
		}
		.footer-note p { margin: 0; color: color-mix(in srgb, var(--rice) 72%, transparent); max-width: 60ch; }

		@media (max-width: 860px) {
			.kit-nav { align-items: flex-start; flex-direction: column; }
			.hero {
				min-height: auto;
				background:
					linear-gradient(180deg, color-mix(in srgb, var(--ivory) 94%, transparent) 0%, color-mix(in srgb, var(--ivory) 88%, transparent) 68%, var(--ivory) 100%),
					url("<?php echo esc_url( get_template_directory_uri() . '/images/hero/hero-korean-beauty.png' ); ?>") center top / cover no-repeat;
			}
			.section__head,
			.logo-board,
			.copy-list { grid-template-columns: 1fr; }
			.grid,
			.palette { grid-template-columns: 1fr; }
			.swatch { min-height: 170px; }
		}
	</style>
</head>
<body>
<main class="kit-shell">
	<nav class="kit-nav" aria-label="<?php esc_attr_e( 'Brand kit sections', 'glow-glow' ); ?>">
		<div class="wordmark">GL<span>O</span>W</div>
		<div class="kit-nav__links">
			<a href="#position"><?php esc_html_e( 'Position', 'glow-glow' ); ?></a>
			<a href="#color"><?php esc_html_e( 'Color', 'glow-glow' ); ?></a>
			<a href="#logo"><?php esc_html_e( 'Logo', 'glow-glow' ); ?></a>
			<a href="#imagery"><?php esc_html_e( 'Imagery', 'glow-glow' ); ?></a>
			<a href="#copy"><?php esc_html_e( 'Copy', 'glow-glow' ); ?></a>
		</div>
	</nav>

	<section class="hero">
		<div class="hero__inner">
			<p class="kicker"><?php esc_html_e( 'Modern Korean Beauty', 'glow-glow' ); ?></p>
			<h1><?php echo wp_kses( __( 'Premium Korean skincare, made <span>simple.</span>', 'glow-glow' ), array( 'span' => array() ) ); ?></h1>
			<p class="hero__copy"><?php esc_html_e( 'Glow curates authentic Korean skincare and makes it approachable through clear education, quiet design, and intuitive shopping. The customer should feel: I finally understand Korean skincare.', 'glow-glow' ); ?></p>
		</div>
	</section>

	<section class="section section--ivory" id="position">
		<div class="section__head">
			<h2><?php esc_html_e( 'Korean skincare is the identity.', 'glow-glow' ); ?></h2>
			<p class="section__intro"><?php esc_html_e( 'The routine still helps customers choose, but it no longer defines the emotional world. Glow is bright, calm, minimal, and trustworthy. Every screen should reduce overwhelm and build confidence.', 'glow-glow' ); ?></p>
		</div>
		<div class="grid">
			<div class="tile">
				<span class="tile__no">01</span>
				<h3><?php esc_html_e( 'Made simple', 'glow-glow' ); ?></h3>
				<p><?php esc_html_e( 'Education appears exactly where a customer needs it: ingredient, skin fit, step, and outcome.', 'glow-glow' ); ?></p>
			</div>
			<div class="tile tile--cream">
				<span class="tile__no">02</span>
				<h3><?php esc_html_e( 'Thoughtfully curated', 'glow-glow' ); ?></h3>
				<p><?php esc_html_e( 'The catalogue should feel selected, not endless. Fewer louder claims, more useful context.', 'glow-glow' ); ?></p>
			</div>
			<div class="tile tile--sage">
				<span class="tile__no">03</span>
				<h3><?php esc_html_e( 'Calm confidence', 'glow-glow' ); ?></h3>
				<p><?php esc_html_e( 'Premium through restraint: clean spacing, clear hierarchy, soft motion, and warm surfaces.', 'glow-glow' ); ?></p>
			</div>
		</div>
	</section>

	<section class="section" id="color">
		<div class="section__head">
			<h2><?php esc_html_e( 'Light is the default.', 'glow-glow' ); ?></h2>
			<p class="section__intro"><?php esc_html_e( 'The new palette is mostly rice, ivory, cream, and soft sage. Yuja remains the signature accent, used sparingly enough that it feels intentional.', 'glow-glow' ); ?></p>
		</div>
		<div class="palette">
			<div class="swatch swatch--rice"><strong>Rice</strong><code>#F7F4EE</code></div>
			<div class="swatch swatch--ivory"><strong>Warm Ivory</strong><code>#FBF8F2</code></div>
			<div class="swatch swatch--cream"><strong>Cream</strong><code>#EEE8DC</code></div>
			<div class="swatch swatch--sage"><strong>Soft Sage</strong><code>#DDE8DF</code></div>
			<div class="swatch swatch--yuja"><strong>Yuja</strong><code>#F2B63C</code></div>
		</div>
	</section>

	<section class="section section--sage" id="logo">
		<div class="section__head">
			<h2><?php esc_html_e( 'The O becomes the signal.', 'glow-glow' ); ?></h2>
			<p class="section__intro"><?php esc_html_e( 'Move away from literal leaf marks. The future logo system should explore circles, light, water, layers, balance, and negative space. It must still work perfectly in monochrome.', 'glow-glow' ); ?></p>
		</div>
		<div class="logo-board">
			<div class="logo-panel">
				<div class="big-wordmark">GL<span>O</span>W</div>
			</div>
			<div class="logo-panel logo-panel--dark">
				<div class="o-system" aria-hidden="true">
					<span class="o-mark"></span>
					<span class="o-mark"></span>
					<span class="o-mark"></span>
					<span class="o-mark"></span>
				</div>
			</div>
		</div>
	</section>

	<section class="section section--ivory" id="imagery">
		<div class="section__head">
			<h2><?php esc_html_e( 'Clean Korean product imagery.', 'glow-glow' ); ?></h2>
			<p class="section__intro"><?php esc_html_e( 'Photography should suggest hydration, clarity, soft daylight, ceramics, cream textures, rice, glass, and healthy skin. Avoid rustic styling, dark leaves, spa scenes, and generic stock photography.', 'glow-glow' ); ?></p>
		</div>
		<div class="grid">
			<div class="tile tile--cream">
				<span class="tile__no">Use</span>
				<h3><?php esc_html_e( 'Glass, water, cream', 'glow-glow' ); ?></h3>
				<p><?php esc_html_e( 'Hydration and transparency are stronger cues than plants or dark shelves.', 'glow-glow' ); ?></p>
			</div>
			<div class="tile">
				<span class="tile__no">Use</span>
				<h3><?php esc_html_e( 'Soft daylight', 'glow-glow' ); ?></h3>
				<p><?php esc_html_e( 'Bright, warm, and minimal. The page should feel easy to enter.', 'glow-glow' ); ?></p>
			</div>
			<div class="tile tile--sage">
				<span class="tile__no">Avoid</span>
				<h3><?php esc_html_e( 'Cultural shortcuts', 'glow-glow' ); ?></h3>
				<p><?php esc_html_e( 'No cherry blossoms, fans, pagodas, or decorative Korean text as a shortcut for identity.', 'glow-glow' ); ?></p>
			</div>
		</div>
	</section>

	<section class="section" id="copy">
		<div class="section__head">
			<h2><?php esc_html_e( 'Beautifully explained.', 'glow-glow' ); ?></h2>
			<p class="section__intro"><?php esc_html_e( 'Copy should make Korean skincare less intimidating. It should clarify, not hype. It should build confidence before it asks for a purchase.', 'glow-glow' ); ?></p>
		</div>
		<div class="copy-list">
			<div>
				<h3><?php esc_html_e( 'Preferred language', 'glow-glow' ); ?></h3>
				<ul>
					<li><?php esc_html_e( 'Thoughtfully curated', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Authentic Korean skincare', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Healthy skin', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Build confidence', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Ingredient focused', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Modern Korean Beauty', 'glow-glow' ); ?></li>
				</ul>
			</div>
			<div>
				<h3><?php esc_html_e( 'Avoid language', 'glow-glow' ); ?></h3>
				<ul>
					<li><?php esc_html_e( 'Transform', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Secret', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Perfect skin', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Age defying', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Flawless', 'glow-glow' ); ?></li>
					<li><?php esc_html_e( 'Revolutionary', 'glow-glow' ); ?></li>
				</ul>
			</div>
		</div>
	</section>

	<footer class="footer-note">
		<div class="wordmark">GL<span>O</span>W</div>
		<p><?php esc_html_e( 'A premium Korean skincare ecommerce brand: minimal, warm, educational, and quietly confident.', 'glow-glow' ); ?></p>
	</footer>
</main>
<?php wp_footer(); ?>
</body>
</html>
