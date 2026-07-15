<?php
/**
 * Brand Kit page served at /brand-kit.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	foreach ( (array) wp_styles()->queue as $h ) {
		wp_dequeue_style( $h );
	}
	foreach ( (array) wp_scripts()->queue as $h ) {
		wp_dequeue_script( $h );
	}
}, 999 );

$brand_uri = get_theme_file_uri( 'images/brand/' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>COVE Appliances Brand Kit</title>
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Roboto+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --porcelain: #F7F6F2;
  --mist-white: #FEFFFE;
  --graphite: #171A1C;
  --liquid-blue: #A9D8F5;
  --cove-blue: #1E88C8;
  --glass-silver: #D9DEE3;
  --cloud-grey: #EEF1F3;
  --deep-navy: #102A43;
  --soft-teal: #BFE5DF;
  --warm-sand: #E8DED0;
  --grade-b: #E6A23C;
  --grade-c: #6B6F76;
  --font-display: "Suisse Int'l", "Neue Haas Grotesk Display", "Inter", system-ui, sans-serif;
  --font-body: "Inter", system-ui, sans-serif;
  --font-mono: "Sohne Mono", "Roboto Mono", monospace;
}
* { box-sizing: border-box; }
body {
  margin: 0;
  background: radial-gradient(circle at 78% 0%, rgba(169, 216, 245, 0.42), transparent 28rem), var(--porcelain);
  color: var(--graphite);
  font-family: var(--font-body);
  line-height: 1.6;
}
img { display: block; max-width: 100%; }
.wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
.hero { min-height: 86vh; display: grid; grid-template-columns: 0.82fr 1.18fr; gap: 56px; align-items: center; padding: 72px 0; }
.brand-lockup { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 44px; }
.mark { width: 46px; height: 46px; border-radius: 18px; background: radial-gradient(circle at 30% 18%, var(--mist-white), transparent 32%), linear-gradient(135deg, var(--liquid-blue), var(--cove-blue)); box-shadow: inset 0 1px 0 rgba(254,255,254,.72), 0 24px 52px -32px rgba(30,136,200,.8); }
.wordmark { font-weight: 750; letter-spacing: .16em; }
.wordmark span { color: #6B747C; font-size: .62rem; letter-spacing: .2em; margin-left: 8px; }
.kicker { margin: 0 0 14px; color: var(--cove-blue); font-family: var(--font-mono); font-size: .75rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; }
h1 { max-width: 10ch; margin: 0; font-family: var(--font-display); font-size: clamp(4rem, 9vw, 8rem); font-weight: 500; line-height: .9; letter-spacing: 0; }
.lead { max-width: 620px; margin: 28px 0 0; color: #52606A; font-size: 1.14rem; }
.hero-media, .image-panel { overflow: hidden; border: 1px solid var(--glass-silver); border-radius: 34px; background: rgba(254,255,254,.78); box-shadow: 0 26px 80px -56px rgba(16,42,67,.55); }
.hero-media { aspect-ratio: 1.32; }
.hero-media img, .image-panel img { width: 100%; height: 100%; object-fit: cover; }
.section { padding: 84px 0; border-top: 1px solid rgba(217,222,227,.9); }
.section-head { max-width: 760px; margin-bottom: 38px; }
h2 { margin: 0; font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 4.6rem); font-weight: 500; line-height: 1; letter-spacing: 0; }
.grid { display: grid; gap: 18px; }
.grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); align-items: center; gap: 42px; }
.palette { grid-template-columns: repeat(5, minmax(0, 1fr)); }
.swatch { overflow: hidden; border: 1px solid var(--glass-silver); border-radius: 20px; background: rgba(254,255,254,.78); }
.swatch-color { height: 140px; }
.swatch-info { padding: 16px; }
.swatch-name { margin: 0; font-weight: 700; }
.swatch-hex { margin: 3px 0 0; color: #66707A; font-family: var(--font-mono); font-size: .78rem; }
.grades { grid-template-columns: repeat(4, minmax(0, 1fr)); }
.grade { padding: 22px; border: 1px solid var(--glass-silver); border-radius: 22px; background: rgba(254,255,254,.8); }
.grade strong { display: block; margin-bottom: 12px; font-family: var(--font-mono); color: var(--cove-blue); }
.grade p { margin: 0; color: #52606A; }
.type-card { padding: 32px; border: 1px solid var(--glass-silver); border-radius: 24px; background: rgba(254,255,254,.78); }
.type-display { margin: 0; font-size: clamp(2.4rem, 7vw, 6rem); line-height: .95; font-weight: 500; }
.type-mono { margin: 18px 0 0; font-family: var(--font-mono); color: var(--cove-blue); }
.voice { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.voice-card { padding: 24px; border: 1px solid var(--glass-silver); border-radius: 22px; background: rgba(254,255,254,.78); }
.voice-card p { margin: 8px 0 0; color: #52606A; }
.footer { padding: 60px 0; background: var(--deep-navy); color: rgba(247,246,242,.76); }
.footer .wrap { display: flex; justify-content: space-between; gap: 24px; align-items: center; flex-wrap: wrap; }
@media (max-width: 900px) {
  .hero, .grid-2, .palette, .grades, .voice { grid-template-columns: 1fr; }
  h1 { max-width: 11ch; }
}
</style>
</head>
<body>
	<main>
		<section class="hero wrap">
			<div>
				<div class="brand-lockup">
					<span class="mark" aria-hidden="true"></span>
					<span class="wordmark">COVE <span>APPLIANCES</span></span>
				</div>
				<p class="kicker">Appliances made clear</p>
				<h1>Premium appliances. Clearly graded.</h1>
				<p class="lead">COVE is a premium online appliance showroom for smart buyers who want trusted brands, clear condition grading, and better value.</p>
			</div>
			<div class="hero-media">
				<img src="<?php echo esc_url( $brand_uri . 'cove-hero-clarity-portal.png' ); ?>" alt="COVE Clarity Portal hero direction">
			</div>
		</section>

		<section class="section">
			<div class="wrap">
				<div class="section-head">
					<p class="kicker">Palette</p>
					<h2>Bright, technical, calm.</h2>
				</div>
				<div class="grid palette">
					<?php
					$colors = array(
						array( 'Porcelain', '#F7F6F2', 'Main background' ),
						array( 'Graphite', '#171A1C', 'Primary text' ),
						array( 'Liquid Blue', '#A9D8F5', 'Morphism and atmosphere' ),
						array( 'Cove Blue', '#1E88C8', 'CTAs and active states' ),
						array( 'Glass Silver', '#D9DEE3', 'Borders and dividers' ),
					);
					foreach ( $colors as $color ) :
						?>
						<div class="swatch">
							<div class="swatch-color" style="background:<?php echo esc_attr( $color[1] ); ?>"></div>
							<div class="swatch-info">
								<p class="swatch-name"><?php echo esc_html( $color[0] ); ?></p>
								<p class="swatch-hex"><?php echo esc_html( $color[1] ); ?></p>
								<p class="swatch-hex"><?php echo esc_html( $color[2] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="wrap grid-2">
				<div class="image-panel">
					<img src="<?php echo esc_url( $brand_uri . 'cove-grade-trust-system.png' ); ?>" alt="COVE grade trust system">
				</div>
				<div>
					<p class="kicker">Grade system</p>
					<h2>Trust comes from clarity, not warnings.</h2>
					<div class="grid grades" style="margin-top:32px;">
						<div class="grade"><strong>New</strong><p>Factory sealed or brand-new condition.</p></div>
						<div class="grade"><strong>A Grade</strong><p>Excellent condition, minimal to no visible marks.</p></div>
						<div class="grade"><strong>B Grade</strong><p>Light cosmetic marks, fully functional.</p></div>
						<div class="grade"><strong>C Grade</strong><p>Visible cosmetic wear, tested and functional.</p></div>
					</div>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="wrap grid-2">
				<div>
					<p class="kicker">Typography</p>
					<div class="type-card">
						<p class="type-display">Big-brand appliances. Better priced.</p>
						<p class="type-mono">MODEL RF-740 | GRADE A | R 12,999</p>
					</div>
				</div>
				<div class="image-panel">
					<img src="<?php echo esc_url( $brand_uri . 'cove-product-card-pdp-system.png' ); ?>" alt="COVE product card and PDP system">
				</div>
			</div>
		</section>

		<section class="section">
			<div class="wrap">
				<div class="section-head">
					<p class="kicker">Voice</p>
					<h2>Calm, clear, confident.</h2>
				</div>
				<div class="grid voice">
					<div class="voice-card"><strong>We say</strong><p>Clearly graded. Tested and verified. Smart value. Simple delivery.</p></div>
					<div class="voice-card"><strong>We avoid</strong><p>Price-only language, vague condition claims, and loud clearance retail energy.</p></div>
					<div class="voice-card"><strong>Customer feeling</strong><p>I am getting a great deal from a brand that feels professional and trustworthy.</p></div>
				</div>
			</div>
		</section>
	</main>

	<footer class="footer">
		<div class="wrap">
			<div class="brand-lockup" style="margin:0;">
				<span class="mark" aria-hidden="true"></span>
				<span class="wordmark" style="color:var(--mist-white);">COVE <span style="color:rgba(247,246,242,.58);">APPLIANCES</span></span>
			</div>
			<p style="margin:0;font-family:var(--font-mono);">Brand Kit | Appliances made clear</p>
		</div>
	</footer>
<?php wp_footer(); ?>
</body>
</html>
