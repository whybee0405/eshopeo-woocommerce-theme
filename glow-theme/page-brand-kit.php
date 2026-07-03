<?php
/**
 * Brand Kit — served at /brand-kit
 * WordPress uses page-{slug}.php automatically for any page whose slug matches.
 * No manual template assignment required. Just publish a page with slug "brand-kit".
 * @package GLOW
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
<title>GLOW — Brand Guidelines v1.0</title>
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Young+Serif&family=Schibsted+Grotesk:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Spline+Sans+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
  --rice:        #F3F2ED;
  --rice-deep:   #E8E6DF;
  --moss:        #2E4636;
  --moss-soft:   #3D5847;
  --yuja:        #F2B63C;
  --yuja-light:  #F9DFA0;
  --ink:         #23281F;
  --seafoam:     #C9DCD2;
  --seafoam-deep: #A8C4B5;
  --petal:       #E8D5CE;
  --petal-deep:  #D5B8AE;
  --muted:       #6F7468;
  --line:        #D8D5CB;
  --font-display: "Young Serif", Georgia, serif;
  --font-body:    "Schibsted Grotesk", system-ui, sans-serif;
  --font-mono:    "Spline Sans Mono", monospace;
  --ease: cubic-bezier(0.22, 1, 0.36, 1);
}
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { margin: 0; font-family: var(--font-body); font-size: 16px; line-height: 1.65; color: var(--ink); background: var(--rice); -webkit-font-smoothing: antialiased; }
p { margin: 0; }
h1,h2,h3,h4 { margin: 0; font-weight: 600; line-height: 1.2; }

.section { padding: 96px clamp(24px, 6vw, 96px); max-width: 1280px; margin-inline: auto; }
.section-label { font-family: var(--font-mono); font-size: 0.72rem; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); margin-bottom: 48px; display: flex; align-items: center; gap: 16px; }
.section-label::after { content: ""; flex: 1; height: 1px; background: var(--line); }
.section-label--light { color: rgba(243,242,237,0.4); }
.section-label--light::after { background: rgba(243,242,237,0.12); }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; }

/* Cover */
.cover { background: var(--moss); min-height: 100svh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 64px clamp(24px, 6vw, 96px); position: relative; overflow: hidden; }
.cover-watermark { position: absolute; font-family: var(--font-display); font-size: clamp(200px, 40vw, 400px); color: rgba(243,242,237,0.04); line-height: 1; user-select: none; pointer-events: none; top: 50%; left: 50%; transform: translate(-50%, -50%); }
.cover-meta { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.16em; text-transform: uppercase; color: rgba(243,242,237,0.3); margin-bottom: 48px; position: relative; }
.cover-hangul { font-family: var(--font-display); font-size: clamp(1.5rem, 4vw, 2.8rem); color: rgba(243,242,237,0.35); letter-spacing: 0.1em; margin-bottom: 16px; position: relative; }
.cover-wordmark { font-family: var(--font-body); font-weight: 700; font-size: clamp(3.5rem, 10vw, 7rem); letter-spacing: 0.22em; color: var(--rice); line-height: 1; margin-bottom: 24px; position: relative; }
.cover-wordmark span { color: var(--yuja); }
.cover-tagline { font-family: var(--font-display); font-size: clamp(1rem, 2.5vw, 1.5rem); font-style: italic; color: rgba(243,242,237,0.55); margin-bottom: 64px; position: relative; letter-spacing: 0.03em; }
.cover-attrs { display: flex; gap: 24px; justify-content: center; flex-wrap: wrap; position: relative; }
.cover-attr { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(243,242,237,0.3); padding: 7px 14px; border: 1px solid rgba(243,242,237,0.1); border-radius: 999px; }
.cover-nav { position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); display: flex; gap: 24px; flex-wrap: wrap; justify-content: center; }
.cover-nav a { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(243,242,237,0.3); text-decoration: none; transition: color 160ms; }
.cover-nav a:hover { color: var(--yuja-light); }

/* Foundation */
.foundation-story h2 { font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); line-height: 1.15; letter-spacing: -0.01em; margin-bottom: 24px; color: var(--ink); }
.foundation-story p { font-size: 1rem; color: var(--muted); line-height: 1.75; margin-bottom: 16px; }
.attrs-grid { display: flex; flex-direction: column; gap: 16px; align-self: start; }
.attr-row { display: flex; gap: 14px; align-items: flex-start; }
.attr-number { font-family: var(--font-mono); font-size: 0.65rem; color: var(--yuja); padding-top: 2px; flex-shrink: 0; min-width: 20px; }
.attr-title { font-weight: 700; font-size: 0.9rem; margin-bottom: 2px; }
.attr-desc { font-size: 0.83rem; color: var(--muted); line-height: 1.55; }
.anti-refs { margin-top: 72px; padding-top: 48px; border-top: 1px solid var(--line); }
.anti-refs h3 { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 24px; }
.anti-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.anti-card { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 20px; }
.anti-card__label { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.08em; text-transform: uppercase; color: #E05858; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
.anti-card__title { font-weight: 700; font-size: 0.85rem; margin-bottom: 6px; }
.anti-card__reason { font-size: 0.78rem; color: var(--muted); line-height: 1.5; }

/* Colors */
.swatch-row { display: grid; gap: 16px; }
.swatch-row--primary   { grid-template-columns: 2fr 1.5fr 1fr 1fr; }
.swatch-row--secondary { grid-template-columns: repeat(4, 1fr); }
.swatch-row--ingredient { grid-template-columns: repeat(4, 1fr); }
.swatch { border-radius: 12px; overflow: hidden; border: 1px solid rgba(0,0,0,0.06); }
.swatch__color { height: 100px; }
.swatch--rice        .swatch__color { background: var(--rice); border-bottom: 1px solid var(--line); }
.swatch--moss        .swatch__color { background: var(--moss); }
.swatch--ink         .swatch__color { background: var(--ink); }
.swatch--yuja        .swatch__color { background: var(--yuja); }
.swatch--seafoam     .swatch__color { background: var(--seafoam); border-bottom: 1px solid var(--line); }
.swatch--petal       .swatch__color { background: var(--petal); border-bottom: 1px solid var(--line); }
.swatch--rice-deep   .swatch__color { background: var(--rice-deep); border-bottom: 1px solid var(--line); }
.swatch--muted       .swatch__color { background: var(--muted); }
.swatch--seafoam-deep .swatch__color { background: var(--seafoam-deep); border-bottom: 1px solid var(--line); }
.swatch--petal-deep  .swatch__color { background: var(--petal-deep); border-bottom: 1px solid var(--line); }
.swatch--moss-soft   .swatch__color { background: var(--moss-soft); }
.swatch--yuja-light  .swatch__color { background: var(--yuja-light); border-bottom: 1px solid var(--line); }
.swatch__info { padding: 14px 16px; background: var(--rice); }
.swatch__name { font-weight: 700; font-size: 0.8rem; margin-bottom: 2px; }
.swatch__hex { font-family: var(--font-mono); font-size: 0.7rem; color: var(--muted); margin-bottom: 6px; }
.swatch__use { font-size: 0.72rem; color: var(--muted); line-height: 1.4; }
.palette-group { margin-bottom: 48px; }
.palette-group__label { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 16px; }
.color-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); margin-bottom: 16px; }
.color-intro p { color: var(--muted); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 48px; }
.color-rationale { padding: 40px; background: var(--rice-deep); border-radius: 16px; border: 1px solid var(--line); margin-top: 48px; }
.color-rationale h3 { font-family: var(--font-display); font-size: 1.2rem; margin-bottom: 20px; }
.rationale-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
.rationale-item h4 { font-size: 0.88rem; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
.rationale-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.rationale-item p { font-size: 0.82rem; color: var(--muted); line-height: 1.6; }

/* Typography */
.type-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); margin-bottom: 16px; }
.type-intro p { color: var(--muted); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 64px; }
.typeface-row { padding: 48px 0; border-top: 1px solid var(--line); }
.typeface-row:last-child { border-bottom: 1px solid var(--line); }
.typeface-meta { display: flex; align-items: baseline; gap: 20px; margin-bottom: 24px; }
.typeface-name { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); }
.typeface-role { font-family: var(--font-mono); font-size: 0.7rem; color: var(--yuja); letter-spacing: 0.04em; }
.young-specimen { font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; letter-spacing: -0.01em; color: var(--ink); margin-bottom: 16px; }
.young-sub { font-family: var(--font-display); font-size: 1.1rem; font-style: italic; color: var(--muted); }
.grotesk-specimen { font-family: var(--font-body); font-size: clamp(1.5rem, 3vw, 2.5rem); font-weight: 600; color: var(--ink); margin-bottom: 12px; }
.grotesk-sub { font-size: 1rem; color: var(--muted); max-width: 580px; line-height: 1.7; }
.mono-specimen { font-family: var(--font-mono); font-size: clamp(1rem, 2.5vw, 1.6rem); color: var(--moss); letter-spacing: 0.04em; margin-bottom: 12px; }
.mono-sub { font-family: var(--font-mono); font-size: 0.8rem; color: var(--muted); letter-spacing: 0.05em; }
.forbidden-fonts { margin-top: 48px; padding: 24px 28px; background: rgba(224,88,88,0.07); border: 1px solid rgba(224,88,88,0.15); border-radius: 12px; }
.forbidden-fonts h4 { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: #C94A4A; margin-bottom: 12px; }
.forbidden-fonts p { font-size: 0.85rem; color: var(--muted); line-height: 1.6; }
.forbidden-list { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 12px; }
.forbidden-tag { font-family: var(--font-mono); font-size: 0.72rem; padding: 4px 12px; background: rgba(224,88,88,0.12); color: #C94A4A; border-radius: 999px; text-decoration: line-through; }

/* Routine System */
.routine-wrap { background: var(--moss); padding: 96px clamp(24px, 6vw, 96px); }
.routine-inner { max-width: 1280px; margin-inline: auto; }
.routine-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); color: var(--rice); margin-bottom: 16px; }
.routine-intro p { color: rgba(243,242,237,0.6); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 56px; }
.routine-steps { display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px; }
.routine-step { background: var(--moss-soft); border-radius: 12px; padding: 24px 16px; text-align: center; border-top: 3px solid transparent; }
.routine-step:nth-child(1) { border-top-color: var(--seafoam); }
.routine-step:nth-child(2) { border-top-color: var(--seafoam-deep); }
.routine-step:nth-child(3) { border-top-color: var(--petal); }
.routine-step:nth-child(4) { border-top-color: var(--yuja); }
.routine-step:nth-child(5) { border-top-color: var(--petal-deep); }
.routine-step:nth-child(6) { border-top-color: var(--seafoam); }
.routine-step:nth-child(7) { border-top-color: var(--yuja-light); }
.routine-step__num { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.1em; color: rgba(243,242,237,0.3); margin-bottom: 10px; }
.routine-step__name { font-weight: 700; font-size: 0.85rem; color: var(--rice); margin-bottom: 6px; line-height: 1.3; }
.routine-step__desc { font-size: 0.72rem; color: rgba(243,242,237,0.5); line-height: 1.5; }
.routine-note { margin-top: 40px; color: rgba(243,242,237,0.4); font-size: 0.85rem; line-height: 1.7; max-width: 800px; }
.routine-note strong { color: rgba(243,242,237,0.7); }

/* Ingredient Badges */
.badge-system { margin-top: 0; }
.badge-system h3 { font-family: var(--font-display); font-size: 1.4rem; margin-bottom: 16px; }
.badge-system p { font-size: 0.9rem; color: var(--muted); margin-bottom: 32px; line-height: 1.65; max-width: 560px; }
.ingredient-badges { display: flex; flex-direction: column; gap: 16px; }
.ib-row { display: flex; gap: 12px; align-items: flex-start; }
.ib-badge { display: inline-flex; align-items: center; gap: 6px; padding: 0.35em 0.9em; border-radius: 999px; font-family: var(--font-mono); font-size: 0.72rem; font-weight: 500; letter-spacing: 0.05em; flex-shrink: 0; min-width: 130px; justify-content: center; }
.ib--seafoam  { background: rgba(201,220,210,0.35); color: #2A6152; border: 1px solid var(--seafoam-deep); }
.ib--petal    { background: rgba(232,213,206,0.4); color: #7A3D31; border: 1px solid var(--petal-deep); }
.ib--moss     { background: rgba(46,70,54,0.12); color: var(--moss); border: 1px solid rgba(46,70,54,0.25); }
.ib--yuja     { background: rgba(242,182,60,0.18); color: #7A5800; border: 1px solid rgba(242,182,60,0.4); }
.ib-desc { font-size: 0.82rem; color: var(--muted); line-height: 1.55; padding-top: 3px; }
.ib-examples { font-family: var(--font-mono); font-size: 0.68rem; color: var(--muted); opacity: 0.7; margin-top: 4px; }

/* Components */
.comp-block { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 36px; margin-bottom: 24px; }
.comp-block__label { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 24px; }
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 0.75em 1.5em; border-radius: 999px; font-family: var(--font-body); font-size: 0.9rem; font-weight: 600; text-decoration: none; cursor: pointer; border: 2px solid transparent; white-space: nowrap; transition: all 160ms; min-height: 44px; }
.btn--moss { background: var(--moss); color: var(--rice); border-color: var(--moss); }
.btn--moss:hover { background: var(--moss-soft); border-color: var(--moss-soft); }
.btn--yuja { background: var(--yuja); color: var(--ink); border-color: var(--yuja); }
.btn--outline { background: transparent; color: var(--ink); border-color: var(--line); }
.btn--outline:hover { border-color: var(--moss); }
.btn--ghost { background: rgba(35,40,31,0.06); color: var(--ink); border-color: transparent; }
.btn-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 16px; }
.badge-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 16px; }
.badge { display: inline-flex; align-items: center; gap: 6px; padding: 0.25em 0.7em; border-radius: 999px; font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.04em; }
.badge--step    { background: rgba(46,70,54,0.1); color: var(--moss); border: 1px solid rgba(46,70,54,0.2); }
.badge--new     { background: rgba(201,220,210,0.35); color: #1D5C4A; border: 1px solid var(--seafoam-deep); }
.badge--best    { background: rgba(242,182,60,0.2); color: #7A5800; border: 1px solid rgba(242,182,60,0.4); }
.price-demo { display: flex; align-items: baseline; gap: 12px; padding: 16px 0; }
.price-regular { font-family: var(--font-mono); font-size: 1.8rem; font-weight: 500; color: var(--ink); }
.mini-card { background: var(--rice); border: 1.5px solid var(--line); border-radius: 16px; overflow: hidden; width: 200px; }
.mini-card__img { aspect-ratio: 1; background: var(--rice-deep); display: flex; align-items: center; justify-content: center; position: relative; }
.mini-card__img-placeholder { font-family: var(--font-mono); font-size: 0.68rem; color: var(--muted); opacity: 0.5; }
.mini-card__badges { position: absolute; top: 10px; left: 10px; display: flex; flex-direction: column; gap: 4px; }
.mini-card__body { padding: 14px; }
.mini-card__routine { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--moss); margin-bottom: 4px; }
.mini-card__title { font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; line-height: 1.3; }
.mini-card__price { font-family: var(--font-mono); font-size: 0.95rem; color: var(--ink); margin-bottom: 10px; }
.mini-card__atc { width: 100%; padding: 0.55em; background: var(--moss); color: var(--rice); border: none; border-radius: 999px; font-family: var(--font-body); font-size: 0.82rem; font-weight: 600; cursor: pointer; min-height: 44px; }
.card-demo { display: flex; gap: 20px; flex-wrap: wrap; }

/* Voice */
.voice-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 48px; }
.voice-col__label { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.dot { width: 8px; height: 8px; border-radius: 50%; }
.voice-col--do .voice-col__label { color: var(--moss); }
.voice-col--do .dot { background: var(--moss); }
.voice-col--dont .voice-col__label { color: #C94A4A; }
.voice-col--dont .dot { background: #C94A4A; }
.voice-example { padding: 16px 18px; border-radius: 10px; margin-bottom: 12px; font-size: 0.9rem; line-height: 1.6; }
.voice-col--do   .voice-example { background: rgba(46,70,54,0.06); border-left: 3px solid var(--moss); }
.voice-col--dont .voice-example { background: rgba(201,74,74,0.05); border-left: 3px solid #C94A4A; }
.voice-example em { font-style: normal; font-weight: 700; display: block; margin-bottom: 4px; font-size: 0.78rem; opacity: 0.6; letter-spacing: 0.03em; }
.intro-h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); margin-bottom: 16px; }
.intro-p { color: var(--muted); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 64px; }

/* Logo */
.logo-usage { background: var(--ink); padding: 96px clamp(24px, 6vw, 96px); }
.logo-usage-inner { max-width: 1280px; margin-inline: auto; }
.logo-usage h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); color: var(--rice); margin-bottom: 16px; }
.logo-usage-intro { color: rgba(243,242,237,0.55); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 48px; }
.logo-demo-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.logo-demo-card { border-radius: 16px; padding: 48px 32px; display: flex; flex-direction: column; align-items: center; gap: 12px; }
.logo-demo-card--on-rice  { background: var(--rice); }
.logo-demo-card--on-moss  { background: var(--moss); }
.logo-demo-card--on-yuja  { background: var(--yuja); }
.logo-wordmark { font-family: var(--font-body); font-weight: 700; font-size: 1.8rem; letter-spacing: 0.2em; }
.logo-demo-card--on-rice .logo-wordmark { color: var(--moss); }
.logo-demo-card--on-moss .logo-wordmark { color: var(--rice); }
.logo-demo-card--on-yuja .logo-wordmark { color: var(--ink); }
.logo-wordmark span { color: var(--yuja); }
.logo-demo-card--on-yuja .logo-wordmark span { color: var(--moss); }
.logo-demo-card--on-moss .logo-wordmark span { color: var(--yuja); }
.logo-demo-caption { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.08em; text-transform: uppercase; text-align: center; }
.logo-demo-card--on-rice .logo-demo-caption { color: var(--muted); }
.logo-demo-card--on-moss .logo-demo-caption { color: rgba(243,242,237,0.35); }
.logo-demo-card--on-yuja .logo-demo-caption { color: rgba(35,40,31,0.5); }

.colophon { background: var(--ink); padding: 48px clamp(24px, 6vw, 96px); display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; border-top: 1px solid rgba(243,242,237,0.08); }
.colophon-wordmark { font-family: var(--font-body); font-weight: 700; letter-spacing: 0.18em; font-size: 1rem; color: var(--rice); }
.colophon-wordmark span { color: var(--yuja); }
.colophon-meta { font-family: var(--font-mono); font-size: 0.7rem; color: rgba(243,242,237,0.3); letter-spacing: 0.06em; text-align: right; line-height: 1.7; }
</style>
</head>
<body>

<section class="cover" id="identity">
  <span class="cover-watermark" aria-hidden="true">光</span>
  <p class="cover-meta">GLOW K-Beauty — Brand Guidelines v1.0</p>
  <p class="cover-hangul" aria-label="Hangul: Geullo">글로우</p>
  <h1 class="cover-wordmark">GL<span>O</span>W</h1>
  <p class="cover-tagline">"Your skin, in its element."</p>
  <div class="cover-attrs">
    <span class="cover-attr">K-Beauty Skincare</span>
    <span class="cover-attr">7-Step Routine System</span>
    <span class="cover-attr">WooCommerce</span>
    <span class="cover-attr">Ingredient-Led</span>
    <span class="cover-attr">Ritual, Not Product</span>
  </div>
  <nav class="cover-nav">
    <a href="#foundation">Brand Foundation</a>
    <a href="#colors">Color System</a>
    <a href="#typography">Typography</a>
    <a href="#routine">Routine System</a>
    <a href="#ingredients">Ingredient Badges</a>
    <a href="#components">UI Components</a>
    <a href="#voice">Brand Voice</a>
    <a href="#logo">Logo Usage</a>
  </nav>
</section>

<section id="foundation" style="background:var(--rice);">
  <div class="section">
    <p class="section-label">02 — Brand Foundation</p>
    <div class="grid-2" style="align-items:start;">
      <div class="foundation-story">
        <h2>Ritual as architecture.</h2>
        <p>GLOW is built on a counterintuitive premise: Korean skincare is more effective when you understand why each step exists. Most K-beauty brands throw 12 products at you. GLOW gives you a system: seven steps, each with a clear job, each product selected because it fits.</p>
        <p style="margin-top:16px;">The brand's single word — GLOW — is honest. It doesn't promise perfect. It describes the condition that comes from consistent, informed skincare: a lit quality to the skin that isn't about concealing anything. The O is gold, the only color accent, earned through the journey not sprinkled everywhere.</p>
        <p style="margin-top:16px;">The brand speaks Korean to signal authenticity without being exclusionary — 글로우 appears as a watermark, a reminder of the origin. The design is moss-and-rice: forest-deep greens and warm off-whites that read as "botanicals" before you ever see an ingredient list.</p>
      </div>
      <div class="attrs-grid">
        <div class="attr-row"><span class="attr-number">01</span><div><p class="attr-title">Ingredient transparency</p><p class="attr-desc">Every product page shows active ingredients prominently, with badges that tell you what each one does. No marketing names without mechanism.</p></div></div>
        <div class="attr-row"><span class="attr-number">02</span><div><p class="attr-title">System thinking</p><p class="attr-desc">Products are organized by the step they belong to (Cleanse, Tone, Treat…). Browse by step before brand. The routine is the architecture of the store.</p></div></div>
        <div class="attr-row"><span class="attr-number">03</span><div><p class="attr-title">Botanically grounded</p><p class="attr-desc">Moss green isn't decoration — it's a visual signal that what's inside the bottle comes from the earth. The palette smells like a forest before you open a product.</p></div></div>
        <div class="attr-row"><span class="attr-number">04</span><div><p class="attr-title">Confident, not clinical</p><p class="attr-desc">We use the science — hyaluronic acid, niacinamide, ceramides — but we explain it warmly. We're not a dermatologist. We're a knowledgeable friend.</p></div></div>
        <div class="attr-row"><span class="attr-number">05</span><div><p class="attr-title">Accumulation over instant results</p><p class="attr-desc">We don't promise overnight miracles. We say: here's what this ingredient does, here's when you'll notice the difference. Trust is built on realistic timelines.</p></div></div>
      </div>
    </div>
    <div class="anti-refs">
      <h3>Four Anti-References — What GLOW Deliberately Avoids</h3>
      <div class="anti-grid">
        <div class="anti-card"><p class="anti-card__label">✗ Avoid</p><p class="anti-card__title">Clinical White</p><p class="anti-card__reason">Pure white, black Inter text, lab photos. Feels like CeraVe — clinical, cold, pharmaceutical. GLOW is warm, not sterile.</p></div>
        <div class="anti-card"><p class="anti-card__label">✗ Avoid</p><p class="anti-card__title">SaaS Landing Page</p><p class="anti-card__reason">Gradient orbs, bold dark-to-purple backgrounds, startup-template energy. Skincare is intimate. SaaS aesthetics are wrong register.</p></div>
        <div class="anti-card"><p class="anti-card__label">✗ Avoid</p><p class="anti-card__title">Luxury Fashion House</p><p class="anti-card__reason">Cormorant/Playfair, Chanel-white, extreme minimalism. Too cold and aspirational. GLOW is accessible and warm, not aspirationally out of reach.</p></div>
        <div class="anti-card"><p class="anti-card__label">✗ Avoid</p><p class="anti-card__title">Generic K-Beauty Cute</p><p class="anti-card__reason">Pink gradients, cherry blossoms, Poppins/Montserrat, pastel everything. Feels like 2018 Etsy. GLOW is mature and botanical.</p></div>
      </div>
    </div>
  </div>
</section>

<section id="colors" style="background:#fff;">
  <div class="section">
    <p class="section-label">03 — Color System</p>
    <div class="color-intro">
      <h2>The forest and the light.</h2>
      <p>GLOW's palette reads as botanical before you read a word. Rice (not white) and ink (not black) are the neutrals. Moss is the brand anchor. Yuja — the Korean citrus — is the earned accent: it appears on the O in GLOW, on the Add-to-Cart button, and almost nowhere else.</p>
    </div>
    <div class="palette-group">
      <p class="palette-group__label">Primary — Brand Anchors</p>
      <div class="swatch-row swatch-row--primary">
        <div class="swatch swatch--moss"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Moss</p><p class="swatch__hex">#2E4636</p><p class="swatch__use">Brand anchor. Header, key sections, primary buttons. Botanical, earthy — not corporate forest green.</p></div></div>
        <div class="swatch swatch--rice"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Rice</p><p class="swatch__hex">#F3F2ED</p><p class="swatch__use">Page background. Off-white with warmth — evokes fermented rice extract without being beige.</p></div></div>
        <div class="swatch swatch--ink"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Ink</p><p class="swatch__hex">#23281F</p><p class="swatch__use">Headings, primary text. Near-black with a green cast — never cold charcoal.</p></div></div>
        <div class="swatch swatch--yuja"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Yuja</p><p class="swatch__hex">#F2B63C</p><p class="swatch__use">Primary CTA, the O in GLOW logo mark. Earned — not scattered. Korean citrus.</p></div></div>
      </div>
    </div>
    <div class="palette-group">
      <p class="palette-group__label">Secondary — Ingredient Badge Palette</p>
      <div class="swatch-row swatch-row--secondary">
        <div class="swatch swatch--seafoam"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Seafoam</p><p class="swatch__hex">#C9DCD2</p><p class="swatch__use">Hydrating/Barrier ingredient badges. Green-sea tone signals moisture.</p></div></div>
        <div class="swatch swatch--petal"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Petal</p><p class="swatch__hex">#E8D5CE</p><p class="swatch__use">Brightening/Pigment badges. Warm blush — suggests light, not pink-girly.</p></div></div>
        <div class="swatch swatch--seafoam-deep"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Seafoam Deep</p><p class="swatch__hex">#A8C4B5</p><p class="swatch__use">Soothing/Botanical badges. Deeper green-sage for plant-origin actives.</p></div></div>
        <div class="swatch swatch--yuja-light"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Yuja Light</p><p class="swatch__hex">#F9DFA0</p><p class="swatch__use">Active/Targeted treatment badges. Light gold for vitamin-family and exfoliating actives.</p></div></div>
      </div>
    </div>
    <div class="palette-group">
      <p class="palette-group__label">Neutrals</p>
      <div class="swatch-row" style="grid-template-columns:repeat(4,1fr);">
        <div class="swatch swatch--rice-deep"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Rice Deep</p><p class="swatch__hex">#E8E6DF</p><p class="swatch__use">Product image backgrounds, card surfaces.</p></div></div>
        <div class="swatch swatch--moss-soft"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Moss Soft</p><p class="swatch__hex">#3D5847</p><p class="swatch__use">Hover states on moss-colored elements.</p></div></div>
        <div class="swatch swatch--muted"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Muted</p><p class="swatch__hex">#6F7468</p><p class="swatch__use">Body text, descriptions. Warm warm olive-gray. 4.8:1 contrast on rice.</p></div></div>
        <div class="swatch swatch--petal-deep"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Petal Deep</p><p class="swatch__hex">#D5B8AE</p><p class="swatch__use">Border accents on petal-toned cards.</p></div></div>
      </div>
    </div>
    <div class="color-rationale">
      <h3>Why this palette works</h3>
      <div class="rationale-grid">
        <div class="rationale-item"><h4><span class="rationale-dot" style="background:var(--yuja);"></span>Yuja is earned</h4><p>Appears exactly twice on every product page: the logo O and the Add-to-Cart button. Everywhere else is moss, rice, and green. The rarity makes it meaningful.</p></div>
        <div class="rationale-item"><h4><span class="rationale-dot" style="background:var(--seafoam);"></span>Badge colors are semantic</h4><p>Each ingredient category has a color. The badge tells you what an ingredient does before you read its name. This is a system, not decoration.</p></div>
        <div class="rationale-item"><h4><span class="rationale-dot" style="background:var(--moss);"></span>Moss over teal</h4><p>Teal reads as "tech" or "health startup." Moss reads as "botanical," "damp soil," "fermented." It matches the product category before you read a word.</p></div>
      </div>
    </div>
  </div>
</section>

<section id="typography" style="background:var(--rice);">
  <div class="section">
    <p class="section-label">04 — Typography</p>
    <div class="type-intro">
      <h2>Three voices, one register.</h2>
      <p>Young Serif for ritual and gravitas. Schibsted Grotesk for warmth and clarity. Spline Sans Mono for ingredients and measurements. Together they read as "informed friend who knows the science."</p>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">Young Serif</span><span class="typeface-role">Display / Headings / Ritual statements</span></div>
      <p class="young-specimen">Skin, in its<br><em style="color:var(--moss);">element.</em></p>
      <p class="young-sub">A modern text serif with warmth and restraint. Slightly condensed proportions — authoritative without coldness.</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--rice-deep);border-radius:10px;border-left:3px solid var(--yuja);"><p style="font-size:0.82rem;color:var(--muted);line-height:1.6;"><strong style="color:var(--ink);">Why Young Serif:</strong> The forbidden alternatives (Cormorant, Playfair) are either too fashion-luxury or too wedding-invitation. Young Serif has editorial seriousness with organic warmth — it photographs like something from a good magazine, not a French fashion house.</p></div>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">Schibsted Grotesk</span><span class="typeface-role">Body / UI / Labels / Navigation</span></div>
      <p class="grotesk-specimen">Your 7-step ritual, simplified.</p>
      <p class="grotesk-sub">A geometric grotesque with just enough personality to feel warm. Confident at every size, clear at small sizes, works natively in most writing systems.</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--rice-deep);border-radius:10px;border-left:3px solid var(--seafoam-deep);"><p style="font-size:0.82rem;color:var(--muted);line-height:1.6;"><strong style="color:var(--ink);">Why Schibsted:</strong> Avoids Inter (too neutral/tech) and Poppins/Montserrat (too generic). Schibsted has a Scandinavian-clean quality that reads as "modern but not cold" — right register for a brand that is scientific but not clinical.</p></div>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">Spline Sans Mono</span><span class="typeface-role">Ingredients / Measurements / Badges / Concentrations</span></div>
      <p class="mono-specimen">Hyaluronic Acid 2% · Niacinamide 10% · Step 04</p>
      <p class="mono-sub">Used exclusively for ingredient names, concentrations, step numbers, and category eyebrows. Monospace gives ingredient lists tabular clarity.</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--rice-deep);border-radius:10px;border-left:3px solid var(--moss);"><p style="font-size:0.82rem;color:var(--muted);line-height:1.6;"><strong style="color:var(--ink);">Why Spline Mono:</strong> Ingredient percentages need to feel precise. Monospace signals "measured fact" — when you see Spline Mono, you're reading a data point, not a claim.</p></div>
    </div>
    <div class="forbidden-fonts">
      <h4>Forbidden Typefaces — These are explicitly banned</h4>
      <p>These fonts are banned because they create the wrong register for GLOW. Using them would push the brand toward one of our four anti-references.</p>
      <div class="forbidden-list">
        <span class="forbidden-tag">Cormorant</span>
        <span class="forbidden-tag">Playfair Display</span>
        <span class="forbidden-tag">Inter</span>
        <span class="forbidden-tag">Poppins</span>
        <span class="forbidden-tag">Montserrat</span>
      </div>
    </div>
  </div>
</section>

<section id="routine" class="routine-wrap">
  <div class="routine-inner">
    <p class="section-label section-label--light">05 — The 7-Step Routine System</p>
    <div class="routine-intro">
      <h2>The site is the routine.</h2>
      <p>GLOW's information architecture maps to the 7-step K-beauty routine. Navigation, filtering, category pages, and product labelling all use this system. The routine isn't just educational content — it's how the store is structured.</p>
    </div>
    <div class="routine-steps">
      <div class="routine-step"><p class="routine-step__num">STEP 01</p><p class="routine-step__name">Oil Cleanse</p><p class="routine-step__desc">Remove sunscreen, makeup, excess sebum. Prep for water cleanse.</p></div>
      <div class="routine-step"><p class="routine-step__num">STEP 02</p><p class="routine-step__name">Water Cleanse</p><p class="routine-step__desc">Remove water-based impurities. pH balance the skin.</p></div>
      <div class="routine-step"><p class="routine-step__num">STEP 03</p><p class="routine-step__name">Exfoliate</p><p class="routine-step__desc">1–3× per week. Dissolve dead cells, prep for absorption.</p></div>
      <div class="routine-step"><p class="routine-step__num">STEP 04</p><p class="routine-step__name">Tone</p><p class="routine-step__desc">Rebalance pH after cleansing. First hydration layer.</p></div>
      <div class="routine-step"><p class="routine-step__num">STEP 05</p><p class="routine-step__name">Treat</p><p class="routine-step__desc">Targeted serums. Vitamin C, retinol, niacinamide, HA.</p></div>
      <div class="routine-step"><p class="routine-step__num">STEP 06</p><p class="routine-step__name">Moisturise</p><p class="routine-step__desc">Seal in treatment layers. Barrier support and plump.</p></div>
      <div class="routine-step"><p class="routine-step__num">STEP 07</p><p class="routine-step__name">Protect</p><p class="routine-step__desc">SPF 30+ daily. Non-negotiable. AM only.</p></div>
    </div>
    <p class="routine-note"><strong>Structural rule:</strong> Every product in the catalogue is assigned a primary step number. This step appears as the first element on every product card (eyebrow) and every PDP above the title. <strong>The routine is the filter system:</strong> "Shop by Step" is the primary navigation — brand and skin type are secondary. Step 03 (Exfoliate) products note their recommended frequency in the UI.</p>
  </div>
</section>

<section id="ingredients" style="background:#fff;">
  <div class="section">
    <p class="section-label">06 — Ingredient Badge System</p>
    <div class="grid-2" style="align-items:start;gap:80px;">
      <div class="badge-system">
        <h3>Badges that teach as they filter.</h3>
        <p>GLOW's ingredient badges appear on product cards and PDPs. They tell customers what an ingredient does before they read its name. Each badge color corresponds to a function category, not an ingredient type.</p>
        <div class="ingredient-badges">
          <div class="ib-row"><span class="ib-badge ib--seafoam">● Hydrating/Barrier</span><div><p class="ib-desc">Ingredients that draw or lock moisture into the skin, or repair the skin barrier.</p><p class="ib-examples">HA · Ceramide · Glycerin · Panthenol · Centella</p></div></div>
          <div class="ib-row"><span class="ib-badge ib--petal">● Brightening/Pigment</span><div><p class="ib-desc">Ingredients that address hyperpigmentation, dullness, or uneven skin tone.</p><p class="ib-examples">Niacinamide · Vitamin C · Kojic Acid · Arbutin · Tranexamic Acid</p></div></div>
          <div class="ib-row"><span class="ib-badge ib--moss">● Botanical/Soothing</span><div><p class="ib-desc">Plant-derived actives that calm inflammation or provide antioxidant support.</p><p class="ib-examples">Centella · Green Tea · Propolis · Chamomile · Mugwort · Galactomyces</p></div></div>
          <div class="ib-row"><span class="ib-badge ib--yuja">● Active/Targeted</span><div><p class="ib-desc">Higher-concentration or prescription-adjacent actives with targeted mechanism.</p><p class="ib-examples">Retinol · BHA · AHA · Azelaic Acid · Bakuchiol</p></div></div>
        </div>
      </div>
      <div>
        <div style="background:var(--rice);border:1px solid var(--line);border-radius:16px;padding:32px;margin-bottom:24px;">
          <p style="font-family:var(--font-mono);font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);margin-bottom:20px;">Product Card — ingredient badge example</p>
          <div class="mini-card" style="width:100%;">
            <div class="mini-card__img">
              <div class="mini-card__badges">
                <span class="badge badge--step" style="font-size:0.62rem;">Step 05</span>
                <span class="ib-badge ib--seafoam" style="font-size:0.62rem;min-width:auto;">● Hydrating</span>
                <span class="ib-badge ib--petal" style="font-size:0.62rem;min-width:auto;">● Brightening</span>
              </div>
              <span class="mini-card__img-placeholder">product image</span>
            </div>
            <div class="mini-card__body">
              <p class="mini-card__routine">TREAT · Step 05</p>
              <p class="mini-card__title">Hyaluronic Acid Serum 2%</p>
              <p class="mini-card__price" style="font-family:var(--font-mono);">R 420</p>
              <button class="mini-card__atc">Add to Routine</button>
            </div>
          </div>
        </div>
        <div style="padding:20px 24px;background:var(--rice-deep);border-radius:12px;border-left:3px solid var(--yuja);">
          <p style="font-size:0.82rem;color:var(--muted);line-height:1.65;"><strong style="color:var(--ink);">Note on "Add to Routine":</strong> GLOW uses "Add to Routine" instead of "Add to Cart" as the primary CTA. It's still a WooCommerce cart action — the text is just more on-brand. Existing WooCommerce hooks handle the cart logic unchanged.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="components" style="background:var(--rice-deep);">
  <div class="section">
    <p class="section-label">07 — UI Components</p>
    <h2 class="intro-h2">Lean and purposeful.</h2>
    <p class="intro-p">Every component derives from the token system. All interactive elements meet 44×44px minimum touch targets and WCAG AA contrast ratios.</p>
    <div class="comp-block">
      <p class="comp-block__label">Buttons</p>
      <div class="btn-row" style="margin-bottom:12px;"><a class="btn btn--moss">Add to Routine</a><a class="btn btn--yuja">Shop the Routine</a><a class="btn btn--outline">Learn More</a><a class="btn btn--ghost">View Ingredients</a></div>
      <p style="font-family:var(--font-mono);font-size:0.7rem;color:var(--muted);letter-spacing:0.05em;">RULE: Primary CTA is always btn--moss or btn--yuja (context-dependent). Only one per viewport section.</p>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Routine Badges &amp; Status Badges</p>
      <div class="badge-row"><span class="badge badge--step">Step 01</span><span class="badge badge--step">Step 04</span><span class="badge badge--step">Step 07</span></div>
      <div class="badge-row"><span class="badge badge--new">New Arrival</span><span class="badge badge--best">Best Seller</span></div>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Price Display — Spline Mono, ink on rice</p>
      <div class="price-demo"><span class="price-regular">R 420</span></div>
      <p style="font-family:var(--font-mono);font-size:0.7rem;color:var(--muted);letter-spacing:0.05em;">GLOW prices are not sale/discounted by default. Single price, Spline Mono, ink color. No RRP strikethrough unless genuinely on promotion.</p>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Product Card — anatomy</p>
      <div class="card-demo">
        <div class="mini-card">
          <div class="mini-card__img">
            <div class="mini-card__badges">
              <span class="badge badge--step" style="font-size:0.62rem;">Step 06</span>
              <span class="ib-badge ib--moss" style="font-size:0.62rem;min-width:auto;">● Soothing</span>
            </div>
            <span class="mini-card__img-placeholder">product image</span>
          </div>
          <div class="mini-card__body">
            <p class="mini-card__routine">MOISTURISE · Step 06</p>
            <p class="mini-card__title">Centella Barrier Cream</p>
            <p class="mini-card__price">R 680</p>
            <button class="mini-card__atc">Add to Routine</button>
          </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;justify-content:center;padding-left:24px;">
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--yuja);min-width:20px;padding-top:2px;">01</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--ink);">Step badge top-left</strong> — navigation cue before ingredient info</p></div>
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--yuja);min-width:20px;padding-top:2px;">02</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--ink);">Ingredient badge below step</strong> — function category, not brand claim</p></div>
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--yuja);min-width:20px;padding-top:2px;">03</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--ink);">Step + category eyebrow</strong> in Spline Mono above product title</p></div>
          <div style="display:flex;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--yuja);min-width:20px;padding-top:2px;">04</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--ink);">"Add to Routine"</strong> — moss background, 44px min height</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="voice" style="background:var(--rice);">
  <div class="section">
    <p class="section-label">08 — Brand Voice</p>
    <h2 class="intro-h2">Knowledgeable friend, not brand copywriter.</h2>
    <p class="intro-p">GLOW writes the way someone who actually studied cosmetic chemistry would speak to you over lunch. Clear, warm, specific. No magic claims. No vague "transforms your skin" language.</p>
    <div class="voice-grid">
      <div class="voice-col voice-col--do">
        <p class="voice-col__label"><span class="dot"></span>Do — GLOW sounds like this</p>
        <div class="voice-example"><em>Ingredient callout</em>"Niacinamide at 10% — the threshold where clinical studies show visible improvement in hyperpigmentation within 4 weeks of daily use."</div>
        <div class="voice-example"><em>Step description</em>"Step 04 is about resetting your skin's pH after cleansing and giving active ingredients the best environment to work. It's the layer that makes everything that follows more effective."</div>
        <div class="voice-example"><em>Realistic timeline</em>"You'll notice texture first, usually within 2–3 weeks. The pigmentation changes take longer — most people see real difference at 6–8 weeks. Give it the time it needs."</div>
      </div>
      <div class="voice-col voice-col--dont">
        <p class="voice-col__label"><span class="dot"></span>Don't — avoid this</p>
        <div class="voice-example"><em>Empty claims</em>"Transform your skin with our revolutionary formula. Unlock the secret to glass skin with this cult-favourite serum."</div>
        <div class="voice-example"><em>Over-clinical</em>"Hyaluronic acid (sodium hyaluronate) activates aquaporin channels to facilitate transepidermal hydration through multiple molecular weight pathways."</div>
        <div class="voice-example"><em>Fear-based</em>"Your skin is aging every day. Don't wait — before it's too late, start your skincare routine with our anti-aging powerhouse."</div>
      </div>
    </div>
  </div>
</section>

<section id="logo" class="logo-usage">
  <div class="logo-usage-inner">
    <p class="section-label section-label--light">09 — Logo Usage</p>
    <h2>The light mark.</h2>
    <p class="logo-usage-intro">GLOW is the wordmark. The O carries the yuja gold — a signal, not decoration. Set in Schibsted Grotesk Bold, wide tracking (0.2em). The Hangul 글로우 appears as a secondary mark on packaging and brand materials.</p>
    <div class="logo-demo-grid">
      <div class="logo-demo-card logo-demo-card--on-rice">
        <p class="logo-wordmark">GL<span>O</span>W</p>
        <p class="logo-demo-caption">On Rice — primary use</p>
      </div>
      <div class="logo-demo-card logo-demo-card--on-moss">
        <p class="logo-wordmark">GL<span>O</span>W</p>
        <p class="logo-demo-caption">On Moss — dark sections</p>
      </div>
      <div class="logo-demo-card logo-demo-card--on-yuja">
        <p class="logo-wordmark">GL<span>O</span>W</p>
        <p class="logo-demo-caption">On Yuja — promo banners</p>
      </div>
    </div>
    <div style="margin-top:24px;padding:40px;background:rgba(243,242,237,0.06);border-radius:16px;border:1px solid rgba(243,242,237,0.08);">
      <p style="font-family:var(--font-mono);font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;color:rgba(243,242,237,0.3);margin-bottom:20px;">Logo don'ts</p>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div style="padding:16px;background:rgba(243,242,237,0.04);border-radius:10px;"><p style="font-family:var(--font-mono);font-size:0.7rem;color:#E05858;margin-bottom:8px;">✗ Never recolor the O</p><p style="font-size:0.78rem;color:rgba(243,242,237,0.35);line-height:1.5;">Yuja is the only valid O color. Never use moss, petal, or seafoam on the O.</p></div>
        <div style="padding:16px;background:rgba(243,242,237,0.04);border-radius:10px;"><p style="font-family:var(--font-mono);font-size:0.7rem;color:#E05858;margin-bottom:8px;">✗ No low-contrast combos</p><p style="font-size:0.78rem;color:rgba(243,242,237,0.35);line-height:1.5;">Never place rice wordmark on yuja-light or seafoam backgrounds — insufficient contrast.</p></div>
        <div style="padding:16px;background:rgba(243,242,237,0.04);border-radius:10px;"><p style="font-family:var(--font-mono);font-size:0.7rem;color:#E05858;margin-bottom:8px;">✗ No font swapping</p><p style="font-size:0.78rem;color:rgba(243,242,237,0.35);line-height:1.5;">Wordmark is always Schibsted Grotesk Bold. Not Young Serif. Not any other face.</p></div>
        <div style="padding:16px;background:rgba(243,242,237,0.04);border-radius:10px;"><p style="font-family:var(--font-mono);font-size:0.7rem;color:#E05858;margin-bottom:8px;">✗ No stacking</p><p style="font-size:0.78rem;color:rgba(243,242,237,0.35);line-height:1.5;">GLOW is always horizontal. Never stack the letters vertically or break it across two lines.</p></div>
      </div>
    </div>
  </div>
</section>

<footer class="colophon">
  <p class="colophon-wordmark">GL<span>O</span>W</p>
  <p class="colophon-meta">Brand Guidelines v1.0 · 2026<br>Young Serif · Schibsted Grotesk · Spline Sans Mono<br>Rice #F3F2ED · Moss #2E4636 · Yuja #F2B63C</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
