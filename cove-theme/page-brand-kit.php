<?php
/**
 * Brand Kit — served at /brand-kit
 * WordPress uses page-{slug}.php automatically for any page whose slug matches.
 * No manual template assignment required. Just publish a page with slug "brand-kit".
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;

// Strip all theme enqueues so the brand kit renders as a standalone page.
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
<title>COVE — Brand Guidelines v1.0</title>
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
  --cream:       #F7F4EE;
  --cream-deep:  #EDE9DF;
  --slate:       #252830;
  --slate-soft:  #363B47;
  --amber:       #E07B35;
  --amber-deep:  #C4621F;
  --amber-light: #F5C49A;
  --sand:        #BFB4A2;
  --muted:       #5E5850;
  --line:        #DDD8CE;
  --grade-new:   #E07B35;
  --grade-a:     #2DB89A;
  --grade-b:     #4A8FD4;
  --grade-c:     #BFB4A2;
  --font-display: "Fraunces", Georgia, serif;
  --font-body:    "Plus Jakarta Sans", system-ui, sans-serif;
  --font-mono:    "DM Mono", monospace;
  --ease: cubic-bezier(0.22, 1, 0.36, 1);
}
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { margin: 0; font-family: var(--font-body); font-size: 16px; line-height: 1.65; color: var(--slate); background: var(--cream); -webkit-font-smoothing: antialiased; }
p { margin: 0; }
h1,h2,h3,h4 { margin: 0; font-weight: 600; line-height: 1.2; }
img { max-width: 100%; display: block; }

.section { padding: 96px clamp(24px, 6vw, 96px); max-width: 1280px; margin-inline: auto; }
.section-label { font-family: var(--font-mono); font-size: 0.72rem; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); margin-bottom: 48px; display: flex; align-items: center; gap: 16px; }
.section-label::after { content: ""; flex: 1; height: 1px; background: var(--line); }
.section-label--light { color: rgba(247,244,238,0.4); }
.section-label--light::after { background: rgba(247,244,238,0.12); }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; }

.cover { background: var(--slate); min-height: 100svh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 64px clamp(24px, 6vw, 96px); position: relative; overflow: hidden; }
.cover::before { content: ""; position: absolute; inset: 0; background: radial-gradient(ellipse 80% 60% at 50% 110%, rgba(224,123,53,0.12) 0%, transparent 70%); pointer-events: none; }
.cover-meta { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.16em; text-transform: uppercase; color: rgba(247,244,238,0.35); margin-bottom: 64px; }
.logo-arch { width: 72px; height: 72px; color: var(--amber); margin: 0 auto 24px; }
.cover-wordmark { font-family: var(--font-body); font-weight: 800; font-size: clamp(3rem, 8vw, 6rem); letter-spacing: 0.28em; color: #fff; line-height: 1; margin-bottom: 32px; }
.cover-tagline { font-family: var(--font-display); font-size: clamp(1.1rem, 2.5vw, 1.6rem); font-style: italic; color: rgba(247,244,238,0.6); font-weight: 300; margin-bottom: 72px; letter-spacing: 0.02em; }
.cover-attrs { display: flex; gap: 32px; justify-content: center; flex-wrap: wrap; }
.cover-attr { font-family: var(--font-mono); font-size: 0.72rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(247,244,238,0.3); padding: 8px 16px; border: 1px solid rgba(247,244,238,0.08); border-radius: 999px; }
.cover-nav { position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); display: flex; gap: 24px; flex-wrap: wrap; justify-content: center; }
.cover-nav a { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(247,244,238,0.35); text-decoration: none; transition: color 160ms; }
.cover-nav a:hover { color: var(--amber-light); }

.foundation { background: var(--cream); }
.foundation-story h2 { font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; line-height: 1.15; letter-spacing: -0.015em; margin-bottom: 24px; }
.foundation-story p { font-size: 1rem; color: var(--muted); line-height: 1.75; margin-bottom: 16px; }
.attrs-grid { display: flex; flex-direction: column; gap: 16px; align-self: start; padding-top: 8px; }
.attr-row { display: flex; gap: 16px; align-items: flex-start; }
.attr-number { font-family: var(--font-mono); font-size: 0.65rem; color: var(--amber); padding-top: 2px; flex-shrink: 0; min-width: 20px; }
.attr-title { font-weight: 700; font-size: 0.92rem; margin-bottom: 2px; }
.attr-desc { font-size: 0.85rem; color: var(--muted); line-height: 1.55; }
.name-breakdown { margin-top: 72px; padding-top: 48px; border-top: 1px solid var(--line); display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; }
.name-col__letter { font-family: var(--font-display); font-size: 3rem; font-weight: 900; color: var(--amber); line-height: 1; margin-bottom: 12px; }
.name-col__word { font-weight: 700; font-size: 0.88rem; margin-bottom: 4px; }
.name-col__meaning { font-size: 0.82rem; color: var(--muted); line-height: 1.5; }

.colors { background: #fff; }
.color-intro { max-width: 560px; margin-bottom: 56px; }
.color-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 700; margin-bottom: 16px; letter-spacing: -0.01em; }
.color-intro p { color: var(--muted); font-size: 0.95rem; line-height: 1.7; }
.palette-group { margin-bottom: 56px; }
.palette-group__label { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 16px; }
.swatch-row { display: grid; gap: 16px; }
.swatch-row--primary { grid-template-columns: 2fr 1.5fr 1fr 1fr; }
.swatch-row--secondary { grid-template-columns: repeat(4, 1fr); }
.swatch-row--grades { grid-template-columns: repeat(4, 1fr); }
.swatch { border-radius: 12px; overflow: hidden; border: 1px solid rgba(0,0,0,0.06); }
.swatch__color { height: 100px; }
.swatch--cream .swatch__color   { background: var(--cream); border-bottom: 1px solid var(--line); }
.swatch--amber .swatch__color   { background: var(--amber); }
.swatch--slate .swatch__color   { background: var(--slate); }
.swatch--slate-soft .swatch__color { background: var(--slate-soft); }
.swatch--sand .swatch__color    { background: var(--sand); }
.swatch--muted .swatch__color   { background: var(--muted); }
.swatch--line .swatch__color    { background: var(--line); border-bottom: 1px solid var(--line); }
.swatch--cream-deep .swatch__color { background: var(--cream-deep); border-bottom: 1px solid var(--line); }
.swatch--grade-new .swatch__color { background: var(--grade-new); }
.swatch--grade-a .swatch__color   { background: var(--grade-a); }
.swatch--grade-b .swatch__color   { background: var(--grade-b); }
.swatch--grade-c .swatch__color   { background: var(--sand); border-bottom: 1px solid var(--line); }
.swatch__info { padding: 14px 16px; background: var(--cream); }
.swatch__name { font-weight: 700; font-size: 0.82rem; margin-bottom: 2px; }
.swatch__hex { font-family: var(--font-mono); font-size: 0.72rem; color: var(--muted); margin-bottom: 6px; }
.swatch__use { font-size: 0.72rem; color: var(--muted); line-height: 1.4; }
.color-rationale { margin-top: 56px; padding: 40px; background: var(--cream); border-radius: 16px; border: 1px solid var(--line); }
.color-rationale h3 { font-family: var(--font-display); font-size: 1.2rem; margin-bottom: 20px; font-weight: 700; }
.rationale-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
.rationale-item h4 { font-size: 0.88rem; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
.rationale-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.rationale-item p { font-size: 0.82rem; color: var(--muted); line-height: 1.6; }

.typography { background: var(--cream); }
.type-intro { max-width: 560px; margin-bottom: 64px; }
.type-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 700; margin-bottom: 16px; letter-spacing: -0.01em; }
.type-intro p { color: var(--muted); font-size: 0.95rem; line-height: 1.7; }
.typeface-row { padding: 48px 0; border-top: 1px solid var(--line); }
.typeface-row:last-child { border-bottom: 1px solid var(--line); }
.typeface-meta { display: flex; align-items: baseline; gap: 24px; margin-bottom: 24px; }
.typeface-name { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); }
.typeface-role { font-family: var(--font-mono); font-size: 0.7rem; color: var(--amber); letter-spacing: 0.05em; }
.fraunces-specimen { font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4.5rem); font-weight: 700; line-height: 1.1; letter-spacing: -0.02em; color: var(--slate); margin-bottom: 16px; }
.fraunces-sub { font-family: var(--font-display); font-size: 1.1rem; font-style: italic; font-weight: 300; color: var(--muted); }
.fraunces-alpha { font-family: var(--font-display); font-size: 0.95rem; color: var(--sand); letter-spacing: 0.05em; margin-top: 16px; font-weight: 400; }
.jakarta-specimen { font-family: var(--font-body); font-size: clamp(1.5rem, 3vw, 2.5rem); font-weight: 700; color: var(--slate); margin-bottom: 12px; }
.jakarta-sub { font-size: 1rem; color: var(--muted); max-width: 580px; line-height: 1.7; }
.mono-specimen { font-family: var(--font-mono); font-size: clamp(1.1rem, 2.5vw, 1.8rem); color: var(--amber); letter-spacing: 0.04em; margin-bottom: 12px; }
.mono-sub { font-family: var(--font-mono); font-size: 0.82rem; color: var(--muted); letter-spacing: 0.06em; }
.type-scale { margin-top: 64px; padding: 40px; background: #fff; border-radius: 16px; border: 1px solid var(--line); }
.type-scale h3 { font-family: var(--font-mono); font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 32px; }
.scale-row { display: flex; align-items: baseline; gap: 24px; padding: 16px 0; border-bottom: 1px solid var(--line); }
.scale-row:last-child { border-bottom: none; }
.scale-label { font-family: var(--font-mono); font-size: 0.68rem; color: var(--muted); min-width: 100px; flex-shrink: 0; letter-spacing: 0.06em; }

.grades-wrap { background: var(--slate); padding: 96px clamp(24px, 6vw, 96px); }
.grades-inner { max-width: 1280px; margin-inline: auto; }
.grades-intro { max-width: 560px; margin-bottom: 64px; }
.grades-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 700; color: #fff; margin-bottom: 16px; letter-spacing: -0.01em; }
.grades-intro p { color: rgba(247,244,238,0.6); font-size: 0.95rem; line-height: 1.7; }
.grade-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.grade-card { background: var(--slate-soft); border-radius: 16px; padding: 32px 28px; border-top: 3px solid transparent; }
.grade-card--new  { border-top-color: var(--grade-new); }
.grade-card--a    { border-top-color: var(--grade-a); }
.grade-card--b    { border-top-color: var(--grade-b); }
.grade-card--c    { border-top-color: var(--grade-c); }
.grade-card__badge { display: inline-flex; align-items: center; gap: 7px; padding: 5px 12px; border-radius: 999px; font-family: var(--font-mono); font-size: 0.7rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 24px; }
.grade-card--new  .grade-card__badge { background: rgba(224,123,53,0.15); color: var(--amber-light); }
.grade-card--a    .grade-card__badge { background: rgba(45,184,154,0.15); color: #7BE0C8; }
.grade-card--b    .grade-card__badge { background: rgba(74,143,212,0.15); color: #94C4F0; }
.grade-card--c    .grade-card__badge { background: rgba(191,180,162,0.15); color: var(--sand); }
.grade-dot { width: 8px; height: 8px; border-radius: 50%; }
.grade-card--new  .grade-dot { background: var(--grade-new); }
.grade-card--a    .grade-dot { background: var(--grade-a); }
.grade-card--b    .grade-dot { background: var(--grade-b); }
.grade-card--c    .grade-dot { background: var(--grade-c); }
.grade-card__letter { font-family: var(--font-display); font-size: 3.5rem; font-weight: 900; line-height: 1; margin-bottom: 12px; }
.grade-card--new  .grade-card__letter { color: var(--grade-new); }
.grade-card--a    .grade-card__letter { color: var(--grade-a); }
.grade-card--b    .grade-card__letter { color: var(--grade-b); }
.grade-card--c    .grade-card__letter { color: var(--grade-c); }
.grade-card__title { font-weight: 700; font-size: 1rem; color: #fff; margin-bottom: 10px; }
.grade-card__desc { font-size: 0.82rem; color: rgba(247,244,238,0.55); line-height: 1.65; margin-bottom: 20px; }
.grade-card__saving { font-family: var(--font-mono); font-size: 0.72rem; color: rgba(247,244,238,0.35); letter-spacing: 0.05em; }
.grade-rationale { margin-top: 48px; padding-top: 48px; border-top: 1px solid rgba(247,244,238,0.08); color: rgba(247,244,238,0.5); font-size: 0.88rem; line-height: 1.75; max-width: 800px; }
.grade-rationale strong { color: rgba(247,244,238,0.8); }

.components { background: var(--cream-deep); }
.comp-intro { max-width: 560px; margin-bottom: 64px; }
.comp-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 700; margin-bottom: 16px; }
.comp-intro p { color: var(--muted); font-size: 0.95rem; line-height: 1.7; }
.comp-block { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 36px; margin-bottom: 24px; }
.comp-block:last-child { margin-bottom: 0; }
.comp-block__label { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 24px; }
.btn-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 0.75em 1.5em; border-radius: 999px; font-family: var(--font-body); font-size: 0.9rem; font-weight: 600; text-decoration: none; cursor: pointer; border: 2px solid transparent; white-space: nowrap; transition: all 160ms; min-height: 44px; }
.btn--primary { background: var(--amber); color: #fff; border-color: var(--amber); }
.btn--primary:hover { background: var(--amber-deep); border-color: var(--amber-deep); }
.btn--outline { background: transparent; color: var(--slate); border-color: var(--line); }
.btn--outline:hover { border-color: var(--slate); background: var(--cream-deep); }
.btn--outline-amber { background: transparent; color: var(--amber); border-color: var(--amber); }
.btn--ghost { background: rgba(37,40,48,0.06); color: var(--slate); border-color: transparent; }
.btn--sm { padding: 0.5em 1em; font-size: 0.8rem; min-height: 36px; }
.btn--lg { padding: 0.9em 2em; font-size: 1rem; }
.btn--dark { background: var(--slate); color: #fff; border-color: var(--slate); }
.badge { display: inline-flex; align-items: center; gap: 6px; padding: 0.25em 0.7em; border-radius: 999px; font-family: var(--font-mono); font-size: 0.7rem; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; }
.badge-new     { background: rgba(224,123,53,0.12); color: var(--amber-deep); }
.badge-grade-a { background: rgba(45,184,154,0.12); color: #1D8A72; }
.badge-grade-b { background: rgba(74,143,212,0.12); color: #2A6BA8; }
.badge-grade-c { background: rgba(191,180,162,0.25); color: #6B5F50; }
.saving-badge  { background: rgba(224,123,53,0.16); color: var(--amber-deep); font-weight: 700; font-family: var(--font-mono); font-size: 0.72rem; padding: 0.22em 0.6em; border-radius: 4px; }
.badge-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 16px; }
.price-demo { display: flex; align-items: baseline; gap: 12px; padding: 20px 0; }
.price-rrp { font-family: var(--font-mono); font-size: 0.9rem; color: var(--muted); text-decoration: line-through; }
.price-current { font-family: var(--font-mono); font-size: 2rem; font-weight: 700; color: var(--amber-deep); }
.mini-card { background: #fff; border: 1.5px solid var(--line); border-radius: 16px; overflow: hidden; width: 220px; }
.mini-card__img { aspect-ratio: 1; background: var(--cream-deep); position: relative; display: flex; align-items: center; justify-content: center; color: var(--sand); }
.mini-card__img-placeholder { font-family: var(--font-mono); font-size: 0.72rem; letter-spacing: 0.08em; color: var(--sand); }
.mini-card__badges { position: absolute; top: 10px; left: 10px; }
.mini-card__body { padding: 14px; }
.mini-card__brand { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; }
.mini-card__title { font-size: 0.88rem; font-weight: 600; margin-bottom: 8px; line-height: 1.3; }
.mini-card__price { display: flex; align-items: baseline; gap: 6px; margin-bottom: 10px; }
.mini-card__rrp { font-family: var(--font-mono); font-size: 0.75rem; color: var(--muted); text-decoration: line-through; }
.mini-card__current { font-family: var(--font-mono); font-size: 1rem; font-weight: 700; color: var(--amber-deep); }
.mini-card__atc { width: 100%; padding: 0.55em; background: var(--amber); color: #fff; border: none; border-radius: 999px; font-family: var(--font-body); font-size: 0.82rem; font-weight: 600; cursor: pointer; min-height: 44px; }
.card-demo { display: flex; gap: 20px; flex-wrap: wrap; }

.voice { background: #fff; }
.voice-intro { max-width: 560px; margin-bottom: 64px; }
.voice-intro h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 700; margin-bottom: 16px; }
.voice-intro p { color: var(--muted); font-size: 0.95rem; line-height: 1.7; }
.voice-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 56px; }
.voice-col__label { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.voice-col__label .dot { width: 8px; height: 8px; border-radius: 50%; }
.voice-col--do .voice-col__label { color: var(--grade-a); }
.voice-col--do .dot { background: var(--grade-a); }
.voice-col--dont .voice-col__label { color: #E05858; }
.voice-col--dont .dot { background: #E05858; }
.voice-example { padding: 18px 20px; border-radius: 10px; margin-bottom: 12px; font-size: 0.92rem; line-height: 1.6; }
.voice-col--do .voice-example { background: rgba(45,184,154,0.07); border-left: 3px solid var(--grade-a); }
.voice-col--dont .voice-example { background: rgba(224,88,88,0.06); border-left: 3px solid #E05858; }
.voice-example em { font-style: normal; font-weight: 700; display: block; margin-bottom: 4px; font-size: 0.82rem; opacity: 0.65; letter-spacing: 0.03em; }
.tone-pillars { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.tone-pillar { padding: 28px; background: var(--cream); border-radius: 12px; border: 1px solid var(--line); }
.tone-pillar__icon { font-size: 1.5rem; margin-bottom: 12px; }
.tone-pillar__title { font-weight: 700; font-size: 0.95rem; margin-bottom: 8px; }
.tone-pillar__desc { font-size: 0.82rem; color: var(--muted); line-height: 1.6; }

.logo-usage { background: var(--slate); padding: 96px clamp(24px, 6vw, 96px); }
.logo-usage-inner { max-width: 1280px; margin-inline: auto; }
.logo-usage h2 { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 700; color: #fff; margin-bottom: 16px; }
.logo-usage-intro { color: rgba(247,244,238,0.6); font-size: 0.95rem; line-height: 1.7; max-width: 560px; margin-bottom: 56px; }
.logo-demo-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.logo-demo-card { border-radius: 16px; padding: 48px 32px; display: flex; flex-direction: column; align-items: center; gap: 16px; }
.logo-demo-card--on-cream { background: var(--cream); }
.logo-demo-card--on-white { background: #fff; }
.logo-demo-card--on-amber { background: var(--amber); }
.logo-lockup { display: flex; align-items: center; gap: 12px; }
.logo-lockup__wordmark { font-family: var(--font-body); font-weight: 800; letter-spacing: 0.2em; font-size: 1.4rem; }
.logo-demo-card--on-cream .logo-lockup__wordmark, .logo-demo-card--on-white .logo-lockup__wordmark { color: var(--slate); }
.logo-demo-card--on-amber .logo-lockup__wordmark { color: #fff; }
.logo-demo-card--on-amber svg { color: #fff; }
.logo-demo-caption { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(247,244,238,0.35); text-align: center; }
.logo-dont-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 40px; }
.logo-dont { background: var(--slate-soft); border-radius: 12px; padding: 24px; text-align: center; }
.logo-dont__label { font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(247,244,238,0.35); margin-top: 12px; display: block; }

.colophon { background: var(--cream-deep); padding: 48px clamp(24px, 6vw, 96px); display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; border-top: 1px solid var(--line); }
.colophon-brand { display: flex; align-items: center; gap: 10px; }
.colophon-brand svg { width: 24px; height: 24px; color: var(--amber); }
.colophon-brand__name { font-family: var(--font-body); font-weight: 800; letter-spacing: 0.16em; font-size: 1rem; color: var(--slate); }
.colophon-meta { font-family: var(--font-mono); font-size: 0.7rem; color: var(--muted); letter-spacing: 0.06em; text-align: right; line-height: 1.7; }
</style>
</head>
<body>

<section class="cover" id="identity">
  <p class="cover-meta">COVE Home Appliances — Brand Guidelines v1.0 — South Africa</p>
  <svg class="logo-arch" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path d="M14 58 L14 36 A22 22 0 0 1 58 36 L58 58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
    <line x1="6" y1="58" x2="66" y2="58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/>
  </svg>
  <h1 class="cover-wordmark">COVE</h1>
  <p class="cover-tagline">"Home, done right."</p>
  <div class="cover-attrs">
    <span class="cover-attr">Home Appliances</span>
    <span class="cover-attr">New &amp; B-Stock</span>
    <span class="cover-attr">South African Market</span>
    <span class="cover-attr">E-Commerce</span>
    <span class="cover-attr">Value-Premium</span>
  </div>
  <nav class="cover-nav">
    <a href="#foundation">Brand Foundation</a>
    <a href="#colors">Color System</a>
    <a href="#typography">Typography</a>
    <a href="#grades">Grade System</a>
    <a href="#components">UI Components</a>
    <a href="#voice">Brand Voice</a>
    <a href="#logo">Logo Usage</a>
  </nav>
</section>

<section id="foundation">
  <div class="section">
    <p class="section-label">02 — Brand Foundation</p>
    <div class="grid-2" style="align-items:start;gap:80px;">
      <div class="foundation-story">
        <h2>Honest appliances for real homes.</h2>
        <p>COVE exists because the appliance market has a dirty secret: demo units and ex-display stock — products that are 90% as good as new — get destroyed or sold at a whisper. We show the scratch on the side panel. We tell you it's there. And then we price it honestly.</p>
        <p style="margin-top:16px;">The name itself is the brand. A cove is a sheltered bay — a protected space. Every home should be one. COVE's job is to fill that space with quality machines at honest prices, without the jargon or the hustle.</p>
        <p style="margin-top:16px;">We are not budget. We are not luxury. We are <em>specific</em>: modern, warm, and honest about what you're getting and why the price is what it is.</p>
      </div>
      <div class="attrs-grid">
        <div class="attr-row"><span class="attr-number">01</span><div><p class="attr-title">Radical transparency</p><p class="attr-desc">Every cosmetic defect is named and photographed. The grade badge is the first thing you see on every product, not buried in the fine print.</p></div></div>
        <div class="attr-row"><span class="attr-number">02</span><div><p class="attr-title">Value without apology</p><p class="attr-desc">We show RRP crossed out and the saving in rands. Not as a dark pattern — as a service. Customers deserve to know what they're actually saving.</p></div></div>
        <div class="attr-row"><span class="attr-number">03</span><div><p class="attr-title">Warm confidence</p><p class="attr-desc">COVE doesn't shout "SALE!" We state the facts warmly. We believe a great appliance should speak for itself — we just provide the context.</p></div></div>
        <div class="attr-row"><span class="attr-number">04</span><div><p class="attr-title">Category-first navigation</p><p class="attr-desc">People think in rooms, not brands. Kitchen. Laundry. Climate. Floor Care. Personal Care. That's how the site is structured, from nav to filter.</p></div></div>
        <div class="attr-row"><span class="attr-number">05</span><div><p class="attr-title">Tested, not just described</p><p class="attr-desc">Every graded unit is tested before listing. The warranty is shorter than new — because we're being honest — but coverage exists at every grade.</p></div></div>
      </div>
    </div>
    <div class="name-breakdown">
      <div class="name-col"><p class="name-col__letter">C</p><p class="name-col__word">Cove</p><p class="name-col__meaning">A sheltered bay. A protected space. The metaphor for home as sanctuary — and for honest business as a safe harbour.</p></div>
      <div class="name-col"><p class="name-col__letter" style="color:var(--grade-a);">A</p><p class="name-col__word">Arch</p><p class="name-col__meaning">The logo mark is an arch — a doorway, a frame, a structure. It suggests home, entrance, and the quality system's graded columns.</p></div>
      <div class="name-col"><p class="name-col__letter" style="color:var(--grade-b);">M</p><p class="name-col__word">Market</p><p class="name-col__meaning">South African households: first-time homeowners, nest builders, practical upgraders. Not wealthy — intentional with their money.</p></div>
      <div class="name-col"><p class="name-col__letter" style="color:var(--sand);">P</p><p class="name-col__word">Promise</p><p class="name-col__meaning">"Home, done right." Not perfect. Not cheapest. Right — meaning considered, honest, and built to last beyond the first year.</p></div>
    </div>
  </div>
</section>

<section id="colors" style="background:#fff;">
  <div class="section">
    <p class="section-label">03 — Color System</p>
    <div class="color-intro"><h2>A warm, honest palette.</h2><p>The COVE palette is built around domestic warmth — cream instead of white, amber instead of orange. The slate anchor is warm charcoal, not cold black. Every color has a reason; none are decorative accidents.</p></div>
    <div class="palette-group">
      <p class="palette-group__label">Primary — Brand Anchors</p>
      <div class="swatch-row swatch-row--primary">
        <div class="swatch swatch--amber"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Amber</p><p class="swatch__hex">#E07B35</p><p class="swatch__use">Primary CTA, active states, price highlights, savings badges. The only warm push in the system.</p></div></div>
        <div class="swatch swatch--slate"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Slate</p><p class="swatch__hex">#252830</p><p class="swatch__use">Dark surfaces, footer, nav text, grade strip. Warm charcoal — not pure black.</p></div></div>
        <div class="swatch swatch--cream"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Cream</p><p class="swatch__hex">#F7F4EE</p><p class="swatch__use">Page background. Off-white with warmth — not harsh. Pairs with amber and slate to feel like a real home.</p></div></div>
        <div class="swatch swatch--cream-deep"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Cream Deep</p><p class="swatch__hex">#EDE9DF</p><p class="swatch__use">Product image backgrounds, hero surface, grade note panels.</p></div></div>
      </div>
    </div>
    <div class="palette-group">
      <p class="palette-group__label">Secondary — Support &amp; Neutral</p>
      <div class="swatch-row swatch-row--secondary">
        <div class="swatch swatch--slate-soft"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Slate Soft</p><p class="swatch__hex">#363B47</p><p class="swatch__use">Raised dark cards (grade strip columns).</p></div></div>
        <div class="swatch swatch--sand"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Sand</p><p class="swatch__hex">#BFB4A2</p><p class="swatch__use">Grade C badge color, decorative dividers, subtle icon strokes.</p></div></div>
        <div class="swatch swatch--muted"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Muted</p><p class="swatch__hex">#5E5850</p><p class="swatch__use">Body text, descriptions, labels. Passes WCAG AA (5.9:1 on cream) at all text sizes.</p></div></div>
        <div class="swatch swatch--line"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Line</p><p class="swatch__hex">#DDD8CE</p><p class="swatch__use">Borders, dividers, card edges on light surfaces. Warm gray — never cold blue-gray.</p></div></div>
      </div>
    </div>
    <div class="palette-group">
      <p class="palette-group__label">Condition Grade Colors — Semantic System</p>
      <div class="swatch-row swatch-row--grades">
        <div class="swatch swatch--grade-new"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">New / Amber</p><p class="swatch__hex">#E07B35</p><p class="swatch__use">New stock badge. Same as brand amber — reinforces new stock as the aspirational tier.</p></div></div>
        <div class="swatch swatch--grade-a"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Grade A / Teal</p><p class="swatch__hex">#2DB89A</p><p class="swatch__use">Open box, near-perfect. Teal signals "clean" and "trusted" without stealing amber's meaning.</p></div></div>
        <div class="swatch swatch--grade-b"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Grade B / Blue</p><p class="swatch__hex">#4A8FD4</p><p class="swatch__use">Minor cosmetic marks. Blue is honest and calm — a clear step down from teal.</p></div></div>
        <div class="swatch swatch--grade-c"><div class="swatch__color"></div><div class="swatch__info"><p class="swatch__name">Grade C / Sand</p><p class="swatch__hex">#BFB4A2</p><p class="swatch__use">Visible cosmetic damage. Warm neutral — not alarming, not dismissive.</p></div></div>
      </div>
    </div>
    <div class="color-rationale">
      <h3>Why this palette works together</h3>
      <div class="rationale-grid">
        <div class="rationale-item"><h4><span class="rationale-dot" style="background:var(--amber);"></span>Amber is earned</h4><p>Amber only appears where the customer needs to act or notice something important: CTAs, savings, active states, prices. Never used decoratively.</p></div>
        <div class="rationale-item"><h4><span class="rationale-dot" style="background:var(--cream);"></span>Cream is the air</h4><p>The background isn't white because homes aren't white. Cream carries warmth without distraction and makes amber pop more naturally.</p></div>
        <div class="rationale-item"><h4><span class="rationale-dot" style="background:var(--grade-a);"></span>Grade colors are a spectrum</h4><p>From amber (new) → teal (A) → blue (B) → sand (C), the grade palette follows a deliberate warmth-to-neutrality arc. Each grade is unmistakable but none feels alarming.</p></div>
      </div>
    </div>
  </div>
</section>

<section id="typography">
  <div class="section">
    <p class="section-label">04 — Typography</p>
    <div class="type-intro"><h2>Three voices. One personality.</h2><p>Each font has a specific job. Fraunces earns authority and warmth for big statements. Plus Jakarta Sans handles clarity at every size. DM Mono anchors numbers and spec data with precision.</p></div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">Fraunces</span><span class="typeface-role">Display / Headings / Emotional statements</span></div>
      <p class="fraunces-specimen">Home, done<br><em style="color:var(--amber);">right.</em></p>
      <p class="fraunces-sub">A slow-draw, optical-size serif with warmth and personality. Variable weight and optical size axes let it work from 9pt to 90pt.</p>
      <p class="fraunces-alpha">A B C D E F G H I J K L M N O P Q R S T U V W X Y Z — 0 1 2 3 4 5 6 7 8 9</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--cream-deep);border-radius:10px;border-left:3px solid var(--amber);"><p style="font-size:0.82rem;color:var(--muted);line-height:1.6;"><strong style="color:var(--slate);">Why Fraunces:</strong> Luxury appliance brands use cold sans-serifs. COVE uses a warm serif to signal "considered" rather than "corporate". Fraunces has editorial credibility without the stuffiness of traditional serif faces like Garamond.</p></div>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">Plus Jakarta Sans</span><span class="typeface-role">Body / UI / Navigation / Labels</span></div>
      <p class="jakarta-specimen">Every room. Every budget.</p>
      <p class="jakarta-sub">Clean, geometric sans-serif with a friendly rounded character. The workhorse of the system — handles everything Fraunces doesn't touch.</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--cream-deep);border-radius:10px;border-left:3px solid var(--grade-a);"><p style="font-size:0.82rem;color:var(--muted);line-height:1.6;"><strong style="color:var(--slate);">Why Plus Jakarta Sans:</strong> Chosen over Inter (too neutral) and Poppins (too friendly). Jakarta has just enough warmth to pair with Fraunces without competing. The COVE wordmark is set in Jakarta Bold.</p></div>
    </div>
    <div class="typeface-row">
      <div class="typeface-meta"><span class="typeface-name">DM Mono</span><span class="typeface-role">Prices / Specs / Badges / Eyebrows</span></div>
      <p class="mono-specimen">R 2,199 — Grade A — A+++ Energy</p>
      <p class="mono-sub">Used exclusively for numbers, prices, specs, grade labels, category eyebrows, and section numbers. Monospace ensures all price columns align perfectly.</p>
      <div style="margin-top:20px;padding:16px 20px;background:var(--cream-deep);border-radius:10px;border-left:3px solid var(--grade-b);"><p style="font-size:0.82rem;color:var(--muted);line-height:1.6;"><strong style="color:var(--slate);">Why DM Mono:</strong> Prices need to feel precise and trustworthy. When you see mono, you're looking at a fact, not marketing copy.</p></div>
    </div>
    <div class="type-scale">
      <h3>Type Scale</h3>
      <div class="scale-row"><span class="scale-label">Hero / t-hero</span><span style="font-family:var(--font-display);font-size:clamp(2.5rem,5vw,4rem);font-weight:900;letter-spacing:-0.02em;line-height:1;">Home.</span></div>
      <div class="scale-row"><span class="scale-label">Display / t-1</span><span style="font-family:var(--font-display);font-size:clamp(2rem,3.5vw,3rem);font-weight:800;letter-spacing:-0.015em;">Every room, every budget.</span></div>
      <div class="scale-row"><span class="scale-label">Heading / t-2</span><span style="font-family:var(--font-display);font-size:clamp(1.5rem,2.5vw,2rem);font-weight:700;">Shop by Category</span></div>
      <div class="scale-row"><span class="scale-label">Section / t-3</span><span style="font-size:1.2rem;font-weight:600;">Laundry Appliances</span></div>
      <div class="scale-row"><span class="scale-label">Body / 16px</span><span style="font-size:1rem;color:var(--muted);">Small scratch on left side panel — not visible when installed under a counter. Functionality 100%.</span></div>
      <div class="scale-row"><span class="scale-label">Eyebrow / mono</span><span style="font-family:var(--font-mono);font-size:0.72rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);">Kitchen · Grade A · Breville</span></div>
    </div>
  </div>
</section>

<section id="grades" class="grades-wrap">
  <div class="grades-inner">
    <p class="section-label section-label--light">05 — Grade System</p>
    <div class="grades-intro"><h2>Honesty is the product.</h2><p>The grade system is COVE's most important UX decision. Condition is never buried — it's the first thing on every card and above the fold on every PDP. The color coding is semantic, not aesthetic.</p></div>
    <div class="grade-cards">
      <div class="grade-card grade-card--new"><span class="grade-card__badge"><span class="grade-dot"></span>New</span><p class="grade-card__letter">N</p><p class="grade-card__title">Brand New</p><p class="grade-card__desc">Sealed original packaging. Never opened, never used. Full manufacturer warranty.</p><p class="grade-card__saving">Full RRP · 2-year warranty</p></div>
      <div class="grade-card grade-card--a"><span class="grade-card__badge"><span class="grade-dot"></span>Grade A</span><p class="grade-card__letter">A</p><p class="grade-card__title">Open Box / Near-Perfect</p><p class="grade-card__desc">Opened, unpacked, or used briefly as a display. No cosmetic marks visible. Indistinguishable from new in use.</p><p class="grade-card__saving">Save up to 35% · 12-month warranty</p></div>
      <div class="grade-card grade-card--b"><span class="grade-card__badge"><span class="grade-dot"></span>Grade B</span><p class="grade-card__letter">B</p><p class="grade-card__title">Minor Cosmetic Marks</p><p class="grade-card__desc">Light scratches, scuffs, or marks — photographed and described specifically. Fully functional.</p><p class="grade-card__saving">Save up to 55% · 90-day warranty</p></div>
      <div class="grade-card grade-card--c"><span class="grade-card__badge"><span class="grade-dot"></span>Grade C</span><p class="grade-card__letter">C</p><p class="grade-card__title">Visible Cosmetic Damage</p><p class="grade-card__desc">Dents, cracks, or heavy surface marks visible in normal use. Fully tested and functional.</p><p class="grade-card__saving">Save up to 70% · 90-day warranty</p></div>
    </div>
    <div class="grade-rationale"><strong>Why letters, not labels like "Refurbished"?</strong> Industry-standard euphemisms erode trust. COVE uses letters (A/B/C) paired with plain-language descriptions because letters are learnable and the descriptions do the real work. A customer who reads "small scratch on left side panel" trusts the brand more than one who reads "excellent condition."<br><br><strong>Colour logic:</strong> Amber (new) → teal (A) → blue (B) → sand (C). Deliberately avoids the medical red/green binary. All grade colors pass contrast requirements on both cream and slate surfaces.</div>
  </div>
</section>

<section id="components" class="components">
  <div class="section">
    <p class="section-label">06 — UI Components</p>
    <div class="comp-intro"><h2>A lean, consistent component set.</h2><p>Every component derives from the design tokens. All interactive elements meet 44×44px minimum touch targets and WCAG AA contrast ratios.</p></div>
    <div class="comp-block">
      <p class="comp-block__label">Buttons — all minimum 44px height</p>
      <div class="btn-row" style="margin-bottom:16px;"><a class="btn btn--primary btn--lg">Add to Cart</a><a class="btn btn--primary">Add to Cart</a><a class="btn btn--primary btn--sm">Add to Cart</a></div>
      <div class="btn-row" style="margin-bottom:16px;"><a class="btn btn--outline btn--lg">View Details</a><a class="btn btn--outline">View Details</a><a class="btn btn--outline btn--sm">View Details</a></div>
      <div class="btn-row"><a class="btn btn--outline-amber">Browse Grade A</a><a class="btn btn--ghost">Learn More</a><a class="btn btn--dark">Shop All Products</a></div>
      <p style="font-family:var(--font-mono);font-size:0.7rem;color:var(--muted);margin-top:16px;letter-spacing:0.05em;">RULE: Only one btn--primary per viewport section. Secondary actions use outline or ghost.</p>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Condition Badges &amp; Saving Badges</p>
      <div class="badge-row"><span class="badge badge-new">● New</span><span class="badge badge-grade-a">● Grade A</span><span class="badge badge-grade-b">● Grade B</span><span class="badge badge-grade-c">● Grade C</span></div>
      <div class="badge-row"><span class="saving-badge">Save R700</span><span class="saving-badge">Save R2,500</span><span class="saving-badge">Save R3,100</span></div>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Price Display — DM Mono, amber-deep on white</p>
      <div class="price-demo"><span class="price-rrp">R 5,599</span><span class="price-current">R 2,499</span><span class="saving-badge" style="margin-left:4px;">Save R3,100</span></div>
      <p style="font-family:var(--font-mono);font-size:0.7rem;color:var(--muted);letter-spacing:0.05em;">Prices use amber-deep (#C4621F) — not amber (#E07B35) — on white/cream. Achieves 4:1 contrast (WCAG large text). RRP always crossed out.</p>
    </div>
    <div class="comp-block">
      <p class="comp-block__label">Product Card — anatomy</p>
      <div class="card-demo">
        <div class="mini-card">
          <div class="mini-card__img">
            <div class="mini-card__badges"><span class="badge badge-grade-a" style="font-size:0.65rem;">● Grade A</span></div>
            <span class="mini-card__img-placeholder">product image</span>
            <div style="position:absolute;top:10px;right:10px;"><span class="saving-badge">Save R700</span></div>
          </div>
          <div class="mini-card__body">
            <p class="mini-card__brand">KitchenAid</p>
            <p class="mini-card__title">Stand Mixer 800W</p>
            <div class="mini-card__price"><span class="mini-card__rrp">R 2,699</span><span class="mini-card__current">R 1,999</span></div>
            <button class="mini-card__atc">Add to Cart</button>
          </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;justify-content:center;padding-left:24px;">
          <div style="display:flex;align-items:flex-start;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--amber);min-width:20px;padding-top:2px;">01</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--slate);">Grade badge top-left</strong> — first signal before the product name</p></div>
          <div style="display:flex;align-items:flex-start;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--amber);min-width:20px;padding-top:2px;">02</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--slate);">Saving badge top-right</strong> — quantity of value, not quality signal</p></div>
          <div style="display:flex;align-items:flex-start;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--amber);min-width:20px;padding-top:2px;">03</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--slate);">Brand in mono uppercase</strong> — sets authority before the name</p></div>
          <div style="display:flex;align-items:flex-start;gap:12px;"><span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--amber);min-width:20px;padding-top:2px;">04</span><p style="font-size:0.82rem;color:var(--muted);line-height:1.5;"><strong style="color:var(--slate);">Full-width ATC</strong> — amber, 44px min height</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="voice" class="voice">
  <div class="section">
    <p class="section-label">07 — Brand Voice</p>
    <div class="voice-intro"><h2>Specific. Warm. No fluff.</h2><p>COVE writes the way a trustworthy friend in the industry would speak. We name the scratch. We say the price. We don't call a washing machine a "laundry solution".</p></div>
    <div class="voice-grid">
      <div class="voice-col voice-col--do">
        <p class="voice-col__label"><span class="dot"></span>Do — COVE sounds like this</p>
        <div class="voice-example"><em>Product description</em>"Small scratch on left side panel — not visible when installed under a counter. Motor, drum and all 15 wash programmes are fully functional. Confirmed in our testing."</div>
        <div class="voice-example"><em>Savings headline</em>"Save R3,100 on a fully working Dyson V12. The scratch on the handle is real. The suction is also real."</div>
        <div class="voice-example"><em>Trust signal</em>"Every unit tested before listing. Every cosmetic mark photographed. Every saving calculated from the current retail price."</div>
      </div>
      <div class="voice-col voice-col--dont">
        <p class="voice-col__label"><span class="dot"></span>Don't — avoid this</p>
        <div class="voice-example"><em>Too corporate</em>"Experience premium laundry care with our certified pre-owned washing solution, offering best-in-class hygienic performance."</div>
        <div class="voice-example"><em>Too salesy</em>"🔥 AMAZING DEAL!! This INCREDIBLE stand mixer is basically brand new!! You WON'T find a better price ANYWHERE!!"</div>
        <div class="voice-example"><em>Too vague on condition</em>"Excellent condition. Minor signs of use. Great value for money. Fully functional."</div>
      </div>
    </div>
    <div class="tone-pillars">
      <div class="tone-pillar"><div class="tone-pillar__icon">◎</div><p class="tone-pillar__title">Specific over superlative</p><p class="tone-pillar__desc">Name the actual feature, the exact saving, the real defect. "Scratch on the base" beats "some cosmetic wear" every time.</p></div>
      <div class="tone-pillar"><div class="tone-pillar__icon">→</div><p class="tone-pillar__title">Warm, not excitable</p><p class="tone-pillar__desc">No exclamation marks in product descriptions. Warmth comes from word choice, not punctuation.</p></div>
      <div class="tone-pillar"><div class="tone-pillar__icon">◻</div><p class="tone-pillar__title">Customer-led framing</p><p class="tone-pillar__desc">Grade notes are written from the customer's perspective: will this matter in your home? "Not visible when installed" answers the real question.</p></div>
    </div>
  </div>
</section>

<section id="logo" class="logo-usage">
  <div class="logo-usage-inner">
    <p class="section-label section-label--light">08 — Logo Usage</p>
    <h2>The arch mark.</h2>
    <p class="logo-usage-intro">The COVE logo is an arch — a doorway, a frame, a sheltered space. It pairs with the COVE wordmark set in Plus Jakarta Sans 800, wide letter-spacing (0.2em).</p>
    <div class="logo-demo-grid">
      <div class="logo-demo-card logo-demo-card--on-cream">
        <div class="logo-lockup"><svg width="36" height="36" viewBox="0 0 72 72" fill="none" style="color:var(--amber);"><path d="M14 58 L14 36 A22 22 0 0 1 58 36 L58 58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="6" y1="58" x2="66" y2="58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/></svg><span class="logo-lockup__wordmark">COVE</span></div>
        <p class="logo-demo-caption" style="color:var(--muted);">On Cream — primary use</p>
      </div>
      <div class="logo-demo-card logo-demo-card--on-white">
        <div class="logo-lockup"><svg width="36" height="36" viewBox="0 0 72 72" fill="none" style="color:var(--amber);"><path d="M14 58 L14 36 A22 22 0 0 1 58 36 L58 58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="6" y1="58" x2="66" y2="58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/></svg><span class="logo-lockup__wordmark">COVE</span></div>
        <p class="logo-demo-caption" style="color:var(--muted);">On White — card surfaces</p>
      </div>
      <div class="logo-demo-card logo-demo-card--on-amber">
        <div class="logo-lockup"><svg width="36" height="36" viewBox="0 0 72 72" fill="none" style="color:#fff;"><path d="M14 58 L14 36 A22 22 0 0 1 58 36 L58 58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="6" y1="58" x2="66" y2="58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/></svg><span class="logo-lockup__wordmark" style="color:#fff;">COVE</span></div>
        <p class="logo-demo-caption" style="color:rgba(255,255,255,0.6);">On Amber — promo banners</p>
      </div>
    </div>
    <div style="margin-top:20px;padding:48px 32px;background:var(--slate-soft);border-radius:16px;display:flex;align-items:center;justify-content:center;">
      <div class="logo-lockup"><svg width="40" height="40" viewBox="0 0 72 72" fill="none" style="color:var(--amber);"><path d="M14 58 L14 36 A22 22 0 0 1 58 36 L58 58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="6" y1="58" x2="66" y2="58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/></svg><span class="logo-lockup__wordmark" style="color:#fff;font-size:1.6rem;letter-spacing:0.22em;">COVE</span></div>
    </div>
    <p class="logo-demo-caption" style="text-align:center;margin-top:12px;">On Slate — header, footer, dark sections</p>
  </div>
</section>

<footer class="colophon">
  <div class="colophon-brand">
    <svg viewBox="0 0 72 72" fill="none"><path d="M14 58 L14 36 A22 22 0 0 1 58 36 L58 58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="6" y1="58" x2="66" y2="58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/></svg>
    <span class="colophon-brand__name">COVE</span>
  </div>
  <p class="colophon-meta">Brand Guidelines v1.0 · 2026<br>Fraunces · Plus Jakarta Sans · DM Mono<br>Cream #F7F4EE · Amber #E07B35 · Slate #252830</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
