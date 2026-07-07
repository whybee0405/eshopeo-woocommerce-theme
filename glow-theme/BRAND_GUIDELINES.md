# GLOW Brand Kit Guidelines

Version: 2.0  
Theme: Glow K-Beauty  
Category: premium Korean skincare ecommerce  
Core idea: Premium Korean skincare, made simple.

This document supersedes the previous v1 positioning. The routine remains an important shopping and education feature, but Korean skincare is the brand identity.

## Brand Position

GLOW is a premium Korean skincare ecommerce brand. We curate authentic Korean skincare and make it approachable through thoughtful education, elegant design, and intuitive shopping.

Glow does not sell miracles. Glow helps customers build confidence in their skincare choices.

Brand promise:

> Premium Korean skincare. Made simple. Thoughtfully curated. Beautifully explained.

## Core Values

- Simplicity
- Transparency
- Authenticity
- Calm confidence
- Education
- Long-term skin health
- Everyday luxury

## Emotional Position

Customers should feel:

> I finally understand Korean skincare.

Every interaction should reduce overwhelm and create clarity.

## Personality

Glow is calm, intelligent, refined, minimal, approachable, modern, optimistic, trustworthy, soft, and quietly premium.

Glow is not loud, trendy, influencer-driven, clinical, earthy, rustic, apothecary, overly feminine, or luxury fashion.

## Language

Avoid:

- Ritual
- Transform
- Miracle
- Luxury
- Exclusive
- Revolutionary
- Secret
- Perfect skin
- Glass skin
- Age defying
- Flawless

Prefer:

- Thoughtfully curated
- Made simple
- Authentic Korean skincare
- Healthy skin
- Build confidence
- Ingredient focused
- Daily care
- Visible improvement
- Skin first
- Modern Korean Beauty

## Korean Design Philosophy

Do not rely on stereotypical Korean imagery. Avoid cherry blossoms, fans, pagodas, obvious Hangul decoration, and traditional patterns.

Use Korean design principles instead: quiet, intentional, minimal, balanced, soft, bright, natural, and restrained.

Reference mood:

- Beauty of Joseon
- Round Lab
- Anua
- Torriden
- Mixsoon
- MUJI
- COS
- Apple
- Aesop

## Color System

The site should feel much lighter than v1. Moss is no longer the emotional center.

Suggested visual balance:

- 70% rice and warm ivory
- 15% warm cream
- 10% soft sage
- 5% yuja

| Token | Hex | Use |
| --- | --- | --- |
| Rice | `#F7F4EE` | Primary page background. Warm, never pure white. |
| Warm Ivory | `#FBF8F2` | Hero and high-clarity surfaces. |
| Cream | `#EEE8DC` | Alternate panels and product image grounds. |
| Ink | `#252922` | Primary text, softened toward green. |
| Soft Sage | `#DDE8DF` | Supporting panels, hydration cues, gentle badges. |
| Sage | `#6F8A78` | Secondary buttons, filter states, small accents. |
| Deep Sage | `#4F6F5B` | Accessible text/button states where contrast is needed. |
| Yuja | `#F2B63C` | Signature accent. Buttons, focus states, logo O, meaningful highlights only. |
| Line | `#DED8CC` | Dividers and quiet borders. |
| Muted | `#72786D` | Support copy and secondary metadata. |

Dark sections should be rare. When needed, use softened ink or deep sage, not forest green.

## Typography

Simplify typography. Hierarchy should come from spacing, scale, and clear weight contrast rather than excessive font changes.

The current production fonts remain acceptable for this phase:

- Schibsted Grotesk for body, UI, labels, navigation, and product information.
- Young Serif only for occasional display emphasis where it still feels restrained.
- Spline Sans Mono only for prices, step numbers, SKUs, concentrations, and compact ingredient facts.

Avoid fashion-editorial typography, luxury serif overload, and high-contrast magazine layouts.

## Logo Direction

The logo should become more iconic while remaining minimal.

Remove literal leaf graphics over time. Avoid botanical cliches.

Explore the `O` as the signature brand element through subtle circles, light, glow, layers, water, droplets, rings, balance, harmony, and negative space.

The logo must work in monochrome.

## Photography

Preferred:

- Soft daylight
- Glass
- Water
- Hydration
- Cream textures
- Rice
- Minimal ceramics
- Clean surfaces
- Subtle shadows
- Floating products
- Editorial product compositions
- Healthy skin with real texture

Avoid:

- Dark leaves
- Moss
- Heavy wood
- Rustic styling
- Spa cliches
- Generic stock imagery
- Clinical lab imagery

## Iconography

Use simple thin-line icons with rounded corners, consistent stroke widths, and minimal detail. Icons should feel calm and Apple-like.

## Product Cards

Keep:

- Step education
- Ingredient transparency
- Educational hierarchy

Improve:

- More whitespace
- Lighter appearance
- Larger product photography
- Clearer CTA hierarchy
- Softer shadows
- Less border emphasis

## UI Style

The interface should feel soft, light, precise, and modern. Every interaction should communicate calm.

Motion should be subtle: gentle fades, soft hover transitions, natural easing. Avoid exaggerated movement.

## Homepage Direction

The homepage should immediately communicate Modern Korean Beauty.

First impression:

- Bright
- Clean
- Minimal
- Premium
- Welcoming
- Simple
- Trustworthy

Not earthy, botanical, or rustic.

## Developer Reference

Important files:

- `glow-theme/page-brand-kit.php` - live `/brand-kit` guidelines page.
- `glow-theme/BRAND_GUIDELINES.md` - written source of truth for v2.
- `glow-theme/style.css` - active design tokens, base styles, homepage sections, motion.
- `glow-theme/front-page.php` - homepage hero, eShopeo search placement, and homepage copy.
- `glow-theme/css/woocommerce.css` - next increment for product card, archive, PDP, checkout, and account refinements.
- `glow-theme/functions.php` - routine helper, brand-kit page creation, WooCommerce helpers.
- `glow-theme/images/Glow K-Beauty - Logo.png` and `glow-theme/images/Glow K-Beauty - Favicon.png` - current production logo and favicon assets.

When adding new UI:

1. Start with bright rice, ivory, cream, and sage.
2. Use yuja sparingly and deliberately.
3. Keep the routine as an educational feature, not the brand personality.
4. Prefer product, hydration, glass, and healthy-skin imagery over botanical scenes.
5. Write copy that clarifies Korean skincare and builds confidence.
