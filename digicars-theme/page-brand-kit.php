<?php
/**
 * Brand Kit — served at /brand-kit
 * WordPress uses page-{slug}.php automatically for any page whose slug matches.
 * No manual template assignment required. Just publish a page with slug "brand-kit".
 * @package DigiCars
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	foreach ( (array) wp_styles()->queue  as $h ) { wp_dequeue_style( $h ); }
	foreach ( (array) wp_scripts()->queue as $h ) { wp_dequeue_script( $h ); }
}, 999 );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digi Cars Group — Brand Guidelines v1.0</title>
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wdth,wght@0,75..125,400..900;1,75..125,400..900&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root {
  --signal:      #F4561D;
  --signal-deep: #C73E0D;
  --signal-light: #F9A88A;
  --carbon:      #14161A;
  --carbon-soft: #20242B;
  --carbon-mid:  #2C3240;
  --paper:       #F6F6F4;
  --paper-deep:  #EAEAE7;
  --volt:        #2B6FF0;
  --volt-light:  #7BA8F7;
  --slate:       #5A626E;
  --slate-light: #8A939E;
  --line:        #DDDCD8;
  --line-dark:   rgba(255,255,255,0.08);
  --font-display: "Archivo", system-ui, sans-serif;
  --font-body:    "Hanken Grotesk", system-ui, sans-serif;
  --font-mono:    "JetBrains Mono", monospace;
  --ease: cubic-bezier(0.22, 1, 0.36, 1);
}
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { margin: 0; font-family: var(--font-body); font-size: 16px; line-height: 1.65; color: var(--carbon); background: var(--carbon); -webkit-font-smoothing: antialiased; }
p { margin: 0; }
h1,h2,h3,h4 { margin: 0; font-weight: 600; line-height: 1.2; }

.section { padding: 96px clamp(24px, 6vw, 96px); max-width: 1280px; margin-inline: auto; }
.section-label { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.14em; text-transform: uppercase; margin-bottom: 48px; display: flex; align-items: center; gap: 16px; }
.section-label--light { color: rgba(246,246,244,0.3); }
.section-label--light::after { content: ""; flex: 1; height: 1px; background: var(--line-dark); }
.section-label--dark { color: var(--slate); }
.section-label--dark::after { content: ""; flex: 1; height: 1px; background: var(--line); }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; }

/* Cover */
.cover {
  background: var(--carbon);
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 48px 48px;
  min-height: 100svh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 64px clamp(24px, 6vw, 96px);
  position: relative;
  overflow: hidden;
}
.cover::before { content: ""; position: absolute; inset: 0; background: radial-gradient(ellipse 70% 50% at 50% 100%, rgba(244,86,29,0.08) 0%, transparent 70%); pointer-events: none; }
.cover-meta { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.16em; text-transform: uppercase; color: rgba(246,246,244,0.25); margin-bottom: 56px; position: relative; }
.cover-icon { width: 64px; height: 64px; margin: 0 auto 24px; color: var(--signal); position: relative; }
.cover-wordmark { font-family: var(--font-display); font-weight: 900; font-size: clamp(3rem, 8vw, 6rem); letter-spacing: 0.04em; font-stretch: expanded; color: var(--paper); line-height: 1; margin-bottom: 8px; position: relative; text-transform: uppercase; }
.cover-sub { font-family: var(--font-mono); font-size: 0.82rem; letter-spacing: 0.18em; text-transform: uppercase; color: var(--signal); margin-bottom: 32px; position: relative; }
.cover-tagline { font-family: var(--font-display); font-size: clamp(1rem, 2.5vw, 1.5rem); font-style: italic; color: rgba(246,246,244,0.4); margin-bottom: 64px; position: relative; font-weight: 400; }
.cover-attrs { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; position: relative; }
.cover-attr { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(246,246,244,0.25); padding: 6px 14px; border: 1px solid rgba(246,246,244,0.08); border-radius: 3px; }
.cover-nav { position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); display: flex; gap: 24px; flex-wrap: wrap; justify-content: center; }
.cover-nav a { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(246,246,244,0.25); text-decoration: none; transition: color 160ms; }
.cover-nav a:hover { color: var(--signal-light); }

/* No Cart Rule — always visible */
.no-cart-rule { background: var(--carbon-soft); border: 1px solid rgba(244,86,29,0.25); border-left: 4px solid var(--signal); border-radius: 8px; padding: 20px 24px; margin-bottom: 40px; }
.no-cart-rule__header { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--signal); margin-bottom: 8px; }
.no-cart-rule__text { font-size: 0.88rem; color: rgba(246,246,244,0.7); line-height: 1.65; }
.no-cart-rule__text strong { color: var(--paper); }

/* Foundation */
.foundation-section { background: var(--carbon-soft); }
.foundation-story h2 { font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; font-stretch: expanded; color: var(--paper); margin-bottom: 24px; letter-spacing: 0.01em; text-transform: uppercase; }
.foundation-story p { font-size: 1rem; color: rgba(246,246,244,0.6); line-height: 1.75; margin-bottom: 16px; }
.attrs-grid { display: flex; flex-direction: column; gap: 16px; }
.attr-row { display: flex; gap: 14px; align-items: flex-start; }
.attr-number { font-family: var(--font-mono); font-size: 0.65rem; color: var(--signal); padding-top: 2px; flex-shrink: 0; min-width: 20px; }
.attr-title { font-weight: 700; font-size: 0.9rem; color: var(--paper); margin-bottom: 2px; }
.attr-desc { font-size: 0.82rem; color: rgba(246,246,244,0.5); line-height: 1.55; }

/* Colors */
.colors-section { background: var(--carbon); }
.swatch-row { display: grid; gap: 14px; }
.swatch-row--primary   { grid-template-columns: 2fr 1.5fr 1fr 1fr; }
.swatch-row--secondary { grid-template-columns: repeat(4, 1fr); }
.swatch { border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06); }
.swatch__color { height: 88px; }
.swatch--signal      .swatch__color { background: var(--signal); }
.swatch--carbon      .swatch__color { background: var(--carbon-soft); border-bottom: 1px solid rgba(255,255,255,0.08); }
.swatch--paper       .swatch__color { background: var(--paper); }
.swatch--volt        .swatch__color { background: var(--volt); }
.swatch--carbon-mid  .swatch__color { background: var(--carbon-mid); }
.swatch--slate       .swatch__color { background: var(--slate); }
.swatch--signal-light .swatch__color { background: var(--signal-light); }
.swatch--volt-light  .swatch__color { background: var(--volt-light); }
.swatch__info { padding: 12px 14px; background: var(--carbon-soft); }
.swatch__name { font-weight: 700; font-size: 0.78rem; color: var(--paper); margin-bottom: 2px; }
.swatch__hex { font-family: var(--font-mono); font-size: 0.68rem; color: var(--slate-light); margin-bottom: 5px; }
.swatch__use { font-size: 0.7rem; color: rgba(246,246,244,0.4); line-height: 1.4; }
.palette-group { margin-bottom: 48px; }
.palette-group__label { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--slate); margin-bottom: 14px; }
.color-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 900; font-stretch: expanded; text-transform: uppercase; color: var(--paper); margin-bottom: 16px; }
.color-intro p { color: rgba(246,246,244,0.55); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 48px; }
.color-rules { margin-top: 48px; display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
.color-rule { background: var(--carbon-soft); border-radius: 10px; padding: 24px; border: 1px solid var(--line-dark); }
.color-rule__dot { width: 12px; height: 12px; border-radius: 50%; margin-bottom: 12px; }
.color-rule h4 { font-size: 0.88rem; font-weight: 700; color: var(--paper); margin-bottom: 8px; }
.color-rule p { font-size: 0.78rem; color: rgba(246,246,244,0.45); line-height: 1.6; }

/* Typography */
.type-section { background: var(--carbon-soft); }
.type-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 900; font-stretch: expanded; text-transform: uppercase; color: var(--paper); margin-bottom: 16px; }
.type-intro p { color: rgba(246,246,244,0.55); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 64px; }
.typeface-row { padding: 48px 0; border-top: 1px solid var(--line-dark); }
.typeface-row:last-child { border-bottom: 1px solid var(--line-dark); }
.typeface-meta { display: flex; align-items: baseline; gap: 20px; margin-bottom: 24px; }
.typeface-name { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--slate-light); }
.typeface-role { font-family: var(--font-mono); font-size: 0.68rem; color: var(--signal); letter-spacing: 0.04em; }
.archivo-specimen { font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; font-stretch: expanded; line-height: 1.05; letter-spacing: 0.02em; color: var(--paper); margin-bottom: 12px; text-transform: uppercase; }
.archivo-sub { font-family: var(--font-display); font-size: 1rem; font-stretch: normal; font-weight: 400; color: var(--slate-light); font-style: italic; }
.hanken-specimen { font-family: var(--font-body); font-size: clamp(1.5rem, 3vw, 2.5rem); font-weight: 600; color: var(--paper); margin-bottom: 12px; }
.hanken-sub { font-size: 1rem; color: rgba(246,246,244,0.55); max-width: 560px; line-height: 1.7; }
.mono-specimen { font-family: var(--font-mono); font-size: clamp(0.9rem, 2vw, 1.4rem); color: var(--signal); letter-spacing: 0.04em; margin-bottom: 10px; }
.mono-sub { font-family: var(--font-mono); font-size: 0.78rem; color: var(--slate-light); letter-spacing: 0.04em; }

/* Concierge System */
.concierge-section { background: var(--carbon); padding: 96px clamp(24px, 6vw, 96px); }
.concierge-inner { max-width: 1280px; margin-inline: auto; }
.concierge-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 900; font-stretch: expanded; color: var(--paper); text-transform: uppercase; margin-bottom: 16px; }
.concierge-intro p { color: rgba(246,246,244,0.55); font-size: 0.95rem; line-height: 1.7; max-width: 600px; margin-bottom: 48px; }
.chip-bar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 48px; }
.chip { display: inline-flex; align-items: center; gap: 6px; padding: 0.45em 1em; border-radius: 3px; font-family: var(--font-mono); font-size: 0.72rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; cursor: pointer; border: 1px solid transparent; transition: all 140ms; }
.chip--active { background: var(--signal); color: var(--paper); border-color: var(--signal); }
.chip--default { background: var(--carbon-soft); color: rgba(246,246,244,0.6); border-color: var(--line-dark); }
.chip--default:hover { border-color: var(--slate); color: var(--paper); }
.chip--volt { background: rgba(43,111,240,0.15); color: var(--volt-light); border-color: rgba(43,111,240,0.3); }
.body-type-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 48px; }
.body-tile { background: var(--carbon-soft); border: 1px solid var(--line-dark); border-radius: 8px; padding: 20px 16px; text-align: center; transition: border-color 140ms; }
.body-tile:hover { border-color: var(--signal); }
.body-tile__icon { font-family: var(--font-mono); font-size: 1.4rem; margin-bottom: 10px; color: var(--signal); }
.body-tile__name { font-family: var(--font-display); font-size: 0.85rem; font-weight: 700; font-stretch: expanded; text-transform: uppercase; color: var(--paper); margin-bottom: 4px; letter-spacing: 0.06em; }
.body-tile__count { font-family: var(--font-mono); font-size: 0.65rem; color: var(--slate-light); letter-spacing: 0.06em; }
.concierge-rule { background: var(--carbon-soft); border-radius: 10px; padding: 28px 32px; border: 1px solid var(--line-dark); }
.concierge-rule h4 { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--signal); margin-bottom: 12px; }
.concierge-rule p { font-size: 0.88rem; color: rgba(246,246,244,0.6); line-height: 1.7; }

/* Components */
.components-section { background: var(--carbon-soft); }
.comp-block { background: var(--carbon); border: 1px solid var(--line-dark); border-radius: 10px; padding: 32px; margin-bottom: 20px; }
.comp-block__label { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--slate-light); margin-bottom: 24px; }
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 0.75em 1.5em; border-radius: 3px; font-family: var(--font-body); font-size: 0.9rem; font-weight: 600; text-decoration: none; cursor: pointer; border: 2px solid transparent; white-space: nowrap; transition: all 140ms; min-height: 44px; letter-spacing: 0.01em; }
.btn--signal { background: var(--signal); color: var(--paper); border-color: var(--signal); }
.btn--signal:hover { background: var(--signal-deep); border-color: var(--signal-deep); }
.btn--outline-paper { background: transparent; color: var(--paper); border-color: rgba(246,246,244,0.25); }
.btn--outline-paper:hover { border-color: var(--paper); }
.btn--outline-signal { background: transparent; color: var(--signal); border-color: var(--signal); }
.btn--ghost { background: rgba(246,246,244,0.06); color: var(--paper); border-color: transparent; }
.btn--volt { background: var(--volt); color: var(--paper); border-color: var(--volt); }
.btn-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 12px; }
.badge { display: inline-flex; align-items: center; gap: 6px; padding: 0.2em 0.7em; border-radius: 3px; font-family: var(--font-mono); font-size: 0.65rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; }
.badge--new       { background: rgba(244,86,29,0.15); color: var(--signal-light); border: 1px solid rgba(244,86,29,0.25); }
.badge--used      { background: rgba(90,98,110,0.25); color: var(--slate-light); border: 1px solid rgba(90,98,110,0.3); }
.badge--ev        { background: rgba(43,111,240,0.15); color: var(--volt-light); border: 1px solid rgba(43,111,240,0.25); }
.badge--featured  { background: rgba(244,86,29,0.1); color: var(--signal); border: 1px solid rgba(244,86,29,0.2); }
.badge-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 16px; }
.spec-row { display: flex; gap: 20px; flex-wrap: wrap; padding: 16px 0; }
.spec-item { display: flex; flex-direction: column; gap: 2px; }
.spec-item__label { font-family: var(--font-mono); font-size: 0.6rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--slate-light); }
.spec-item__value { font-family: var(--font-mono); font-size: 0.85rem; color: var(--paper); font-weight: 500; }
.vehicle-card { background: var(--carbon-soft); border: 1px solid var(--line-dark); border-radius: 8px; overflow: hidden; width: 220px; }
.vehicle-card__img { aspect-ratio: 16/9; background: var(--carbon-mid); display: flex; align-items: center; justify-content: center; position: relative; }
.vehicle-card__img-placeholder { font-family: var(--font-mono); font-size: 0.65rem; color: var(--slate); opacity: 0.5; }
.vehicle-card__condition { position: absolute; top: 8px; left: 8px; }
.vehicle-card__body { padding: 14px; }
.vehicle-card__year { font-family: var(--font-mono); font-size: 0.7rem; color: var(--slate-light); margin-bottom: 4px; letter-spacing: 0.06em; }
.vehicle-card__make { font-family: var(--font-display); font-size: 0.95rem; font-weight: 700; font-stretch: expanded; text-transform: uppercase; color: var(--paper); margin-bottom: 8px; letter-spacing: 0.04em; }
.vehicle-card__specs { font-family: var(--font-mono); font-size: 0.7rem; color: var(--slate-light); margin-bottom: 12px; letter-spacing: 0.04em; }
.vehicle-card__price { font-family: var(--font-mono); font-size: 1.1rem; font-weight: 700; color: var(--paper); margin-bottom: 12px; }
.vehicle-card__cta { width: 100%; padding: 0.6em; background: var(--signal); color: var(--paper); border: none; border-radius: 3px; font-family: var(--font-body); font-size: 0.82rem; font-weight: 600; cursor: pointer; min-height: 44px; letter-spacing: 0.01em; }
.card-demo { display: flex; gap: 20px; flex-wrap: wrap; }
.no-cart-callout { background: rgba(244,86,29,0.08); border: 1px solid rgba(244,86,29,0.2); border-radius: 8px; padding: 16px 20px; margin-top: 16px; font-family: var(--font-mono); font-size: 0.72rem; color: var(--signal-light); letter-spacing: 0.04em; line-height: 1.6; }

/* Voice */
.voice-section { background: var(--carbon); }
.voice-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 900; font-stretch: expanded; text-transform: uppercase; color: var(--paper); margin-bottom: 16px; }
.voice-intro p { color: rgba(246,246,244,0.55); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 64px; }
.voice-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 48px; }
.voice-col__label { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.dot { width: 8px; height: 8px; border-radius: 50%; }
.voice-col--do .voice-col__label { color: var(--signal); }
.voice-col--do .dot { background: var(--signal); }
.voice-col--dont .voice-col__label { color: var(--slate-light); }
.voice-col--dont .dot { background: var(--slate-light); }
.voice-example { padding: 16px 18px; border-radius: 6px; margin-bottom: 12px; font-size: 0.88rem; line-height: 1.65; color: rgba(246,246,244,0.75); }
.voice-col--do   .voice-example { background: rgba(244,86,29,0.07); border-left: 3px solid var(--signal); }
.voice-col--dont .voice-example { background: rgba(255,255,255,0.03); border-left: 3px solid rgba(255,255,255,0.12); }
.voice-example em { font-style: normal; font-weight: 700; display: block; margin-bottom: 4px; font-size: 0.73rem; opacity: 0.5; letter-spacing: 0.08em; font-family: var(--font-mono); text-transform: uppercase; }

/* Logo */
.logo-section { background: var(--carbon-soft); padding: 96px clamp(24px, 6vw, 96px); }
.logo-inner { max-width: 1280px; margin-inline: auto; }
.logo-section-h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 900; font-stretch: expanded; text-transform: uppercase; color: var(--paper); margin-bottom: 16px; }
.logo-intro { color: rgba(246,246,244,0.5); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 48px; }
.logo-demo-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.logo-demo-card { border-radius: 10px; padding: 48px 32px; display: flex; flex-direction: column; align-items: center; gap: 10px; border: 1px solid var(--line-dark); }
.logo-demo-card--on-carbon { background: var(--carbon); }
.logo-demo-card--on-signal { background: var(--signal); }
.logo-demo-card--on-paper  { background: var(--paper); }
.logo-wordmark { font-family: var(--font-display); font-weight: 900; font-stretch: expanded; font-size: 1.8rem; letter-spacing: 0.08em; text-transform: uppercase; line-height: 1; }
.logo-wordmark-sub { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.18em; text-transform: uppercase; margin-top: 4px; }
.logo-demo-card--on-carbon .logo-wordmark { color: var(--paper); }
.logo-demo-card--on-carbon .logo-wordmark span { color: var(--signal); }
.logo-demo-card--on-carbon .logo-wordmark-sub { color: var(--slate-light); }
.logo-demo-card--on-signal .logo-wordmark { color: var(--paper); }
.logo-demo-card--on-signal .logo-wordmark span { color: var(--carbon); }
.logo-demo-card--on-signal .logo-wordmark-sub { color: rgba(246,246,244,0.6); }
.logo-demo-card--on-paper  .logo-wordmark { color: var(--carbon); }
.logo-demo-card--on-paper  .logo-wordmark span { color: var(--signal); }
.logo-demo-card--on-paper  .logo-wordmark-sub { color: var(--slate); }
.logo-demo-caption { font-family: var(--font-mono); font-size: 0.62rem; letter-spacing: 0.1em; text-transform: uppercase; text-align: center; margin-top: 8px; }
.logo-demo-card--on-carbon .logo-demo-caption { color: rgba(246,246,244,0.2); }
.logo-demo-card--on-signal .logo-demo-caption { color: rgba(246,246,244,0.4); }
.logo-demo-card--on-paper  .logo-demo-caption { color: var(--slate); }

.colophon { background: var(--carbon); padding: 48px clamp(24px, 6vw, 96px); display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; border-top: 1px solid var(--line-dark); }
.colophon-wordmark { font-family: var(--font-display); font-weight: 900; font-stretch: expanded; letter-spacing: 0.08em; font-size: 1.1rem; text-transform: uppercase; color: var(--paper); }
.colophon-wordmark span { color: var(--signal); }
.colophon-meta { font-family: var(--font-mono); font-size: 0.65rem; color: var(--slate); letter-spacing: 0.06em; text-align: right; line-height: 1.7; }
</style>
</head>
<body>

<section class="cover" id="identity">
  <p class="cover-meta">Digi Cars Group — Brand Guidelines v1.0 — South Africa</p>
  <svg class="cover-icon" viewBox="0 0 64 64" fill="none" aria-hidden="true">
    <path d="M8 42 L12 26 Q13 22 17 20 L21 18 L43 18 L47 20 Q51 22 52 26 L56 42" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
    <rect x="6" y="40" width="52" height="12" rx="4" stroke="currentColor" stroke-width="3"/>
    <circle cx="18" cy="52" r="5" fill="currentColor" opacity="0.4"/>
    <circle cx="46" cy="52" r="5" fill="currentColor" opacity="0.4"/>
    <line x1="22" y1="27" x2="42" y2="27" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
  </svg>
  <h1 class="cover-wordmark">DIGI CARS</h1>
  <p class="cover-sub">GROUP</p>
  <p class="cover-tagline">"Find your drive."</p>
  <div class="cover-attrs">
    <span class="cover-attr">Car Marketplace</span>
    <span class="cover-attr">WooCommerce</span>
    <span class="cover-attr">No Cart — Enquire Only</span>
    <span class="cover-attr">Concierge Discovery</span>
    <span class="cover-attr">South Africa</span>
  </div>
  <nav class="cover-nav">
    <a href="#foundation">Foundation</a>
    <a href="#colors">Color System</a>
    <a href="#typography">Typography</a>
    <a href="#concierge">Concierge System</a>
    <a href="#components">UI Components</a>
    <a href="#voice">Brand Voice</a>
    <a href="#logo">Logo Usage</a>
  </nav>
</section>

<section id="foundation" class="foundation-section">
  <div class="section">
    <p class="section-label section-label--light">02 — Brand Foundation</p>
    <div class="no-cart-rule">
      <p class="no-cart-rule__header">⚠ Critical Architectural Rule — Read First</p>
      <p class="no-cart-rule__text"><strong>No cart. Ever.</strong> Digi Cars Group is a vehicle marketplace, not an e-commerce store. WooCommerce is used for product/listing management only. The cart is fully disabled — all checkout flows, cart pages, and "Add to Cart" buttons are removed. Every customer action is either <strong>Enquire</strong> or <strong>Apply for Finance</strong>. This is non-negotiable and affects every UI component, CTA, and user flow in the system.</p>
    </div>
    <div class="grid-2" style="align-items:start;">
      <div class="foundation-story">
        <h2>The Car You Missed Shouldn't Stay Missed.</h2>
        <p style="color:rgba(246,246,244,0.6);">Digi Cars Group operates at the intersection of the used vehicle market's biggest problem: discovery. South African buyers spend hours on classifieds, filtering manually, missing vehicles that perfectly fit their needs because the search was built for database operators, not buyers.</p>
        <p style="margin-top:16px;color:rgba(246,246,244,0.6);">The Concierge Discovery System changes this. Body type, budget, fuel preference, transmission, mileage — chips that narrow in real time, no page reload. The vehicle listing page is the search interface. Browsing is the point of entry, not a form.</p>
        <p style="margin-top:16px;color:rgba(246,246,244,0.6);">The visual language is carbon-first. Dark, heavy, precise — like a showroom floor at night, lit by the vehicles themselves. Signal orange appears where action is required. Volt blue signals AI features and electric vehicles. Nothing else borrows these colors.</p>
      </div>
      <div class="attrs-grid">
        <div class="attr-row"><span class="attr-number">01</span><div><p class="attr-title">Enquire, not purchase</p><p class="attr-desc">Every vehicle action is Enquire (call/WhatsApp) or Apply for Finance. No add-to-cart, no checkout, no online payment. This is a lead-generation marketplace.</p></div></div>
        <div class="attr-row"><span class="attr-number">02</span><div><p class="attr-title">Concierge Discovery</p><p class="attr-desc">The filter system is the UX. Chips that update the listing in real time. Budget, body type, fuel, transmission, mileage — stacked or independent.</p></div></div>
        <div class="attr-row"><span class="attr-number">03</span><div><p class="attr-title">Carbon-first visuals</p><p class="attr-desc">Dark background as the dominant surface. Vehicles are the only "colour" on the page — photography does the emotional lifting. The chrome is minimal.</p></div></div>
        <div class="attr-row"><span class="attr-number">04</span><div><p class="attr-title">Signal is earned</p><p class="attr-desc">Signal orange (#F4561D) appears on CTAs and key data only. It is never decorative. One orange element per card, maximum.</p></div></div>
        <div class="attr-row"><span class="attr-number">05</span><div><p class="attr-title">Volt is for AI and EV only</p><p class="attr-desc">Volt blue (#2B6FF0) exists exclusively for AI-powered features (Concierge AI, price estimate) and EV/PHEV vehicle badges. Nowhere else.</p></div></div>
      </div>
    </div>
  </div>
</section>

<section id="colors" class="colors-section">
  <div class="section">
    <p class="section-label section-label--light">03 — Color System</p>
    <div class="color-intro">
      <h2>Carbon. Signal. Paper.</h2>
      <p>Three primary surfaces. One earned accent. One reserved accent. The system is designed so that signal orange cannot be overused — its power depends on its rarity.</p>
    </div>
    <div class="palette-group">
      <p class="palette-group__label">Primary — Brand Anchors</p>
      <div class="swatch-row swatch-row--primary">
        <div class="swatch swatch--signal"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Signal</p><p class="swatch__hex">#F4561D</p><p class="swatch__use">Primary CTAs (Enquire, Finance), featured badges, key data points. Maximum one per card.</p></div></div>
        <div class="swatch swatch--carbon"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Carbon</p><p class="swatch__hex">#14161A / #20242B</p><p class="swatch__use">Page backgrounds (two shades for depth). The dominant visual surface.</p></div></div>
        <div class="swatch swatch--paper"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Paper</p><p class="swatch__hex">#F6F6F4</p><p class="swatch__use">Text on dark surfaces. Card text. Off-white to avoid harsh contrast.</p></div></div>
        <div class="swatch swatch--volt"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Volt</p><p class="swatch__hex">#2B6FF0</p><p class="swatch__use">AI features and EV/PHEV badges only. Never used elsewhere.</p></div></div>
      </div>
    </div>
    <div class="palette-group">
      <p class="palette-group__label">Supporting — Surfaces &amp; States</p>
      <div class="swatch-row swatch-row--secondary">
        <div class="swatch swatch--carbon-mid"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Carbon Mid</p><p class="swatch__hex">#2C3240</p><p class="swatch__use">Raised cards, hover states on dark surfaces.</p></div></div>
        <div class="swatch swatch--slate"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Slate</p><p class="swatch__hex">#5A626E</p><p class="swatch__use">Secondary text, specs, labels, dividers. Cool gray anchor.</p></div></div>
        <div class="swatch swatch--signal-light"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Signal Light</p><p class="swatch__hex">#F9A88A</p><p class="swatch__use">Tinted text on dark surfaces where signal is used as a bg. Badge text.</p></div></div>
        <div class="swatch swatch--volt-light"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Volt Light</p><p class="swatch__hex">#7BA8F7</p><p class="swatch__use">AI/EV badge text on dark surfaces. Never used outside volt context.</p></div></div>
      </div>
    </div>
    <div class="color-rules">
      <div class="color-rule"><div class="color-rule__dot" style="background:var(--signal);"></div><h4>Signal is earned</h4><p>Enquire button, Apply for Finance, featured price. One per card. Never background-fill a section with signal. Never decorative.</p></div>
      <div class="color-rule"><div class="color-rule__dot" style="background:var(--volt);"></div><h4>Volt is locked to AI/EV</h4><p>The AI Concierge chip, price estimate AI badge, and EV/PHEV vehicle condition badges. If it's not AI or electric, it's not volt.</p></div>
      <div class="color-rule"><div class="color-rule__dot" style="background:var(--paper);"></div><h4>Carbon carries everything</h4><p>The page is dark. Photography provides the only warm color in the product grid. Don't fight it with colored section backgrounds.</p></div>
    </div>
  </div>
</section>

<section id="typography" class="type-section">
  <div class="section">
    <p class="section-label section-label--light">04 — Typography</p>
    <div class="type-intro">
      <h2>Expanded. Precise. Legible.</h2>
      <p>Archivo's expanded weight is the character of the brand — wide, heavy, uppercase. Hanken Grotesk handles body and UI with clarity. JetBrains Mono owns specs and pricing. Never swap these roles.</p>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">Archivo</span><span class="typeface-role">Display / Headings / Vehicle Names — Expanded, Bold</span></div>
      <p class="archivo-specimen">FIND YOUR<br><span style="color:var(--signal);">DRIVE.</span></p>
      <p class="archivo-sub">Variable axes: width 75–125 (use 100–125 for display), weight 400–900. For brand display, always use width:expanded (font-stretch: expanded) at weight 900.</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--carbon-mid);border-radius:6px;border-left:3px solid var(--signal);"><p style="font-size:0.82rem;color:rgba(246,246,244,0.6);line-height:1.6;"><strong style="color:var(--paper);">Why Archivo Expanded:</strong> Vehicle brands use condensed type. We go the other direction — expanded gives presence and authority without resorting to luxury-condensed conventions. The width signals something different about how this marketplace approaches cars.</p></div>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">Hanken Grotesk</span><span class="typeface-role">Body / UI Labels / Navigation / Descriptions</span></div>
      <p class="hanken-specimen">South Africa's car-search, upgraded.</p>
      <p class="hanken-sub">Clean, neutral grotesque — technically excellent, zero personality conflict with Archivo. The invisible workhorse of the system.</p>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">JetBrains Mono</span><span class="typeface-role">Prices / Specs / Year / Odometer / VIN / Chip Labels</span></div>
      <p class="mono-specimen">2022 · 45,000 km · 2.0L · R 299,900</p>
      <p class="mono-sub">All data that is a measured fact uses JetBrains Mono. Prices, mileage, engine capacity, year, VIN. Tabular figures ensure columns align.</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--carbon-mid);border-radius:6px;border-left:3px solid var(--slate);"><p style="font-size:0.82rem;color:rgba(246,246,244,0.6);line-height:1.6;"><strong style="color:var(--paper);">Why JetBrains Mono:</strong> Developers use it because specs are specs. Vehicle buyers are making a R200k-R600k decision. Monospace data signals precision. If it's a number or measurement, it goes in mono. No exceptions.</p></div>
    </div>
  </div>
</section>

<section id="concierge" class="concierge-section">
  <div class="concierge-inner">
    <p class="section-label section-label--light">05 — Concierge Discovery System</p>
    <div class="concierge-intro">
      <h2>The Filter IS the Interface.</h2>
      <p>The Concierge Discovery System is the defining UX of Digi Cars Group. A chip-based filter bar that updates vehicle listings in real time. No search button, no page reload. Chips are stacked (multi-select), not exclusive. Volt chip = AI-powered feature.</p>
    </div>
    <p style="font-family:var(--font-mono);font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-light);margin-bottom:16px;">Live Filter Bar — as it appears on the listing page</p>
    <div class="chip-bar">
      <span class="chip chip--active">Sedan</span>
      <span class="chip chip--default">SUV</span>
      <span class="chip chip--default">Hatch</span>
      <span class="chip chip--default">Bakkie</span>
      <span class="chip chip--default">Coupe</span>
      <span class="chip chip--default">MPV</span>
      <span class="chip chip--default">Ute</span>
      <span class="chip chip--default">Van</span>
      <span class="chip chip--volt">⚡ EV / PHEV</span>
      <span class="chip chip--default">Under R200k</span>
      <span class="chip chip--default">R200k–R400k</span>
      <span class="chip chip--default">R400k+</span>
      <span class="chip chip--volt">✦ AI Concierge</span>
      <span class="chip chip--default">Manual</span>
      <span class="chip chip--default">Auto</span>
      <span class="chip chip--default">Under 50k km</span>
    </div>
    <p style="font-family:var(--font-mono);font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-light);margin-bottom:16px;">Body Type Grid — 8 canonical types</p>
    <div class="body-type-grid">
      <div class="body-tile"><div class="body-tile__icon">▬</div><p class="body-tile__name">Sedan</p><p class="body-tile__count">12 available</p></div>
      <div class="body-tile"><div class="body-tile__icon">▭</div><p class="body-tile__name">SUV</p><p class="body-tile__count">24 available</p></div>
      <div class="body-tile"><div class="body-tile__icon">⬛</div><p class="body-tile__name">Hatch</p><p class="body-tile__count">18 available</p></div>
      <div class="body-tile"><div class="body-tile__icon">◼</div><p class="body-tile__name">Bakkie</p><p class="body-tile__count">9 available</p></div>
      <div class="body-tile"><div class="body-tile__icon">⬦</div><p class="body-tile__name">Coupe</p><p class="body-tile__count">5 available</p></div>
      <div class="body-tile"><div class="body-tile__icon">▪</div><p class="body-tile__name">MPV</p><p class="body-tile__count">7 available</p></div>
      <div class="body-tile"><div class="body-tile__icon">▬</div><p class="body-tile__name">Ute</p><p class="body-tile__count">3 available</p></div>
      <div class="body-tile"><div class="body-tile__icon">▭</div><p class="body-tile__name">Van</p><p class="body-tile__count">4 available</p></div>
    </div>
    <div class="concierge-rule">
      <h4>Concierge system rules</h4>
      <p>Chips are multi-select and stack (selecting "SUV" + "Under R200k" shows SUVs under R200k). Volt chips (AI Concierge, EV/PHEV) are always distinct — volt color signals a non-standard feature. The AI Concierge chip triggers a side panel where natural language input refines the listing. Budget chips are approximate — final price is always in the vehicle card in JetBrains Mono. The filter bar scrolls horizontally on mobile; chips never wrap to a second row on desktop listing view.</p>
    </div>
  </div>
</section>

<section id="components" class="components-section">
  <div class="section">
    <p class="section-label section-label--light">06 — UI Components</p>
    <h2 style="font-family:var(--font-display);font-size:clamp(1.8rem,3vw,2.5rem);font-weight:900;font-stretch:expanded;text-transform:uppercase;color:var(--paper);margin-bottom:16px;">No cart. Only action.</h2>
    <p style="color:rgba(246,246,244,0.55);font-size:0.95rem;line-height:1.7;max-width:560px;margin-bottom:48px;">Every component reflects the marketplace model. CTAs are Enquire and Finance. Never "Add to Cart", "Buy Now", or "Purchase".</p>
    <div class="comp-block">
      <p class="comp-block__label">CTAs — Enquire &amp; Finance are the only primary actions</p>
      <div class="btn-row" style="margin-bottom:12px;"><a class="btn btn--signal">Enquire Now</a><a class="btn btn--signal">Apply for Finance</a></div>
      <div class="btn-row" style="margin-bottom:12px;"><a class="btn btn--outline-paper">View Full Specs</a><a class="btn btn--outline-signal">Save Vehicle</a><a class="btn btn--ghost">Share</a></div>
      <div class="btn-row"><a class="btn btn--volt">✦ AI Concierge</a></div>
      <div class="no-cart-callout">PROHIBITED: "Add to Cart" · "Buy Now" · "Purchase" · "Add to Basket" · Any WooCommerce default cart CTA must be removed or overridden.</div>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Vehicle Condition &amp; Feature Badges</p>
      <div class="badge-row"><span class="badge badge--new">New</span><span class="badge badge--used">Used</span><span class="badge badge--used">Demo</span><span class="badge badge--ev">⚡ EV</span><span class="badge badge--ev">⚡ PHEV</span><span class="badge badge--featured">Featured</span></div>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Spec Display — JetBrains Mono, all data fields</p>
      <div class="spec-row">
        <div class="spec-item"><span class="spec-item__label">Year</span><span class="spec-item__value">2022</span></div>
        <div class="spec-item"><span class="spec-item__label">Mileage</span><span class="spec-item__value">45,000 km</span></div>
        <div class="spec-item"><span class="spec-item__label">Engine</span><span class="spec-item__value">2.0L Turbo</span></div>
        <div class="spec-item"><span class="spec-item__label">Trans</span><span class="spec-item__value">6-Speed Auto</span></div>
        <div class="spec-item"><span class="spec-item__label">Fuel</span><span class="spec-item__value">Petrol</span></div>
        <div class="spec-item"><span class="spec-item__label">Colour</span><span class="spec-item__value">Midnight Blue</span></div>
      </div>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Vehicle Card — anatomy (no cart CTA)</p>
      <div class="card-demo">
        <div class="vehicle-card">
          <div class="vehicle-card__img">
            <div class="vehicle-card__condition"><span class="badge badge--used" style="font-size:0.58rem;">Used</span></div>
            <span class="vehicle-card__img-placeholder">vehicle photo</span>
          </div>
          <div class="vehicle-card__body">
            <p class="vehicle-card__year">2022 · 45,000 km</p>
            <p class="vehicle-card__make">Toyota Fortuner</p>
            <p class="vehicle-card__specs">2.8 GD-6 · Auto · Diesel</p>
            <p class="vehicle-card__price">R 589,900</p>
            <button class="vehicle-card__cta">Enquire Now</button>
          </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;justify-content:center;padding-left:24px;">
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.62rem;color:var(--signal);min-width:20px;padding-top:2px;">01</span><p style="font-size:0.82rem;color:rgba(246,246,244,0.55);line-height:1.5;"><strong style="color:var(--paper);">Condition badge top-left</strong> — New / Used / Demo</p></div>
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.62rem;color:var(--signal);min-width:20px;padding-top:2px;">02</span><p style="font-size:0.82rem;color:rgba(246,246,244,0.55);line-height:1.5;"><strong style="color:var(--paper);">Year + mileage in mono</strong> — first data row, always</p></div>
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.62rem;color:var(--signal);min-width:20px;padding-top:2px;">03</span><p style="font-size:0.82rem;color:rgba(246,246,244,0.55);line-height:1.5;"><strong style="color:var(--paper);">Make/model in Archivo expanded</strong> — the brand moment</p></div>
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.62rem;color:var(--signal);min-width:20px;padding-top:2px;">04</span><p style="font-size:0.82rem;color:rgba(246,246,244,0.55);line-height:1.5;"><strong style="color:var(--paper);">Core specs one line</strong> in mono — capacity, trans, fuel</p></div>
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.62rem;color:var(--signal);min-width:20px;padding-top:2px;">05</span><p style="font-size:0.82rem;color:rgba(246,246,244,0.55);line-height:1.5;"><strong style="color:var(--paper);">"Enquire Now"</strong> — signal, 44px min, always this text</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="voice" class="voice-section">
  <div class="section">
    <p class="section-label section-label--light">07 — Brand Voice</p>
    <div class="voice-intro">
      <h2>DIRECT. SPECIFIC. ZERO FLUFF.</h2>
      <p>Digi Cars Group writes the way a knowledgeable dealer with nothing to hide would speak. Specs, not adjectives. Condition, not spin. Price, not "incredible value". The car's story is in the numbers.</p>
    </div>
    <div class="voice-grid">
      <div class="voice-col voice-col--do">
        <p class="voice-col__label"><span class="dot"></span>Do — Digi Cars sounds like this</p>
        <div class="voice-example"><em>Vehicle description</em>"2022 Toyota Fortuner 2.8 GD-6. 45,000 km. One owner, full service history at Toyota. Navigation system fitted. Minor scuff on rear bumper — photographed in listing."</div>
        <div class="voice-example"><em>Price framing</em>"R 589,900. Finance available from R 6,200/month over 72 months with 10% deposit. Enquire for current prime rate calculation."</div>
        <div class="voice-example"><em>Concierge prompt</em>"You're looking at 24 SUVs under R400k. Narrow by fuel type, mileage, or transmission — or tell the AI Concierge what matters most."</div>
      </div>
      <div class="voice-col voice-col--dont">
        <p class="voice-col__label"><span class="dot"></span>Don't — avoid this</p>
        <div class="voice-example"><em>Vague adjectives</em>"This amazing, well-maintained vehicle is a real head-turner in fantastic condition. Don't miss out on this incredible opportunity!"</div>
        <div class="voice-example"><em>Soft-sell price</em>"Priced to sell! Make an offer — we won't be beaten. Best deal in Johannesburg. Limited time opportunity."</div>
        <div class="voice-example"><em>Hiding condition</em>"Minor wear consistent with age. Normal road use. See in person to appreciate the true condition."</div>
      </div>
    </div>
  </div>
</section>

<section id="logo" class="logo-section">
  <div class="logo-inner">
    <p class="section-label section-label--light">08 — Logo Usage</p>
    <h2 class="logo-section-h2">The signal mark.</h2>
    <p class="logo-intro">DIGI CARS is always uppercase, always Archivo Expanded at weight 900. "GROUP" appears as a sub-label in JetBrains Mono, optional. The DG monogram (not shown here) is the icon-only variant for favicons and app contexts.</p>
    <div class="logo-demo-grid">
      <div class="logo-demo-card logo-demo-card--on-carbon">
        <p class="logo-wordmark">DIGI <span>CARS</span></p>
        <p class="logo-wordmark-sub">GROUP</p>
        <p class="logo-demo-caption">On Carbon — primary use</p>
      </div>
      <div class="logo-demo-card logo-demo-card--on-signal">
        <p class="logo-wordmark">DIGI <span>CARS</span></p>
        <p class="logo-wordmark-sub">GROUP</p>
        <p class="logo-demo-caption">On Signal — hero banners</p>
      </div>
      <div class="logo-demo-card logo-demo-card--on-paper">
        <p class="logo-wordmark">DIGI <span>CARS</span></p>
        <p class="logo-wordmark-sub">GROUP</p>
        <p class="logo-demo-caption">On Paper — light print contexts</p>
      </div>
    </div>
    <div style="margin-top:24px;background:var(--carbon);border-radius:10px;padding:32px;border:1px solid var(--line-dark);">
      <p style="font-family:var(--font-mono);font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-light);margin-bottom:20px;">Logo don'ts</p>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
        <div style="padding:16px;background:var(--carbon-soft);border-radius:8px;"><p style="font-family:var(--font-mono);font-size:0.68rem;color:var(--signal);margin-bottom:8px;">✗ No lowercase</p><p style="font-size:0.78rem;color:rgba(246,246,244,0.35);line-height:1.5;">DIGI CARS is always uppercase. The brand does not have a lowercase form.</p></div>
        <div style="padding:16px;background:var(--carbon-soft);border-radius:8px;"><p style="font-family:var(--font-mono);font-size:0.68rem;color:var(--signal);margin-bottom:8px;">✗ No volt wordmark</p><p style="font-size:0.78rem;color:rgba(246,246,244,0.35);line-height:1.5;">Only signal and paper/carbon are valid wordmark colors. Volt is for AI/EV, not branding.</p></div>
        <div style="padding:16px;background:var(--carbon-soft);border-radius:8px;"><p style="font-family:var(--font-mono);font-size:0.68rem;color:var(--signal);margin-bottom:8px;">✗ No condensed variant</p><p style="font-size:0.78rem;color:rgba(246,246,244,0.35);line-height:1.5;">Always font-stretch: expanded. Never narrow or condensed — that's the competition's move.</p></div>
        <div style="padding:16px;background:var(--carbon-soft);border-radius:8px;"><p style="font-family:var(--font-mono);font-size:0.68rem;color:var(--signal);margin-bottom:8px;">✗ No light weight</p><p style="font-size:0.78rem;color:rgba(246,246,244,0.35);line-height:1.5;">Wordmark is always weight 900. Thin or regular weight wordmarks lose the brand's authority.</p></div>
      </div>
    </div>
  </div>
</section>

<footer class="colophon">
  <p class="colophon-wordmark">DIGI <span>CARS</span></p>
  <p class="colophon-meta">Brand Guidelines v1.0 · 2026<br>Archivo Expanded · Hanken Grotesk · JetBrains Mono<br>Signal #F4561D · Carbon #14161A · Paper #F6F6F4 · Volt #2B6FF0</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
