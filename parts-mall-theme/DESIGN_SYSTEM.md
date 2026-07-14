# Parts Mall Design System

## Brand stance

Parts Mall Africa should feel industrial, credible, and current. The site is not an ecommerce storefront in tone. It is a national automotive supply brand with global backing, local branch access, and trade authority.

Three guiding words:

- Direct
- Mechanical
- Dependable

## System goals

- Remove the generic AI-site feel
- Improve conversion through clearer hierarchy and cleaner CTAs
- Make branch, wholesale, and authority messaging feel intentional
- Standardise typography, spacing, surfaces, and controls for consistent rollout

## Typography

- Display: `Barlow Condensed`
- Body: `Archivo`
- Mono: `JetBrains Mono`

## Type scale

- Display: `clamp(2.8rem, 6vw, 5.2rem)`
- H1: `clamp(2.2rem, 4vw, 3.7rem)`
- H2: `clamp(1.55rem, 2.2vw, 2.15rem)`
- H3: `clamp(1.14rem, 1.35vw, 1.34rem)`
- Body: `1rem`
- Large body: `clamp(1.04rem, 1.2vw, 1.12rem)`
- Overline: `0.75rem`

## Color system

### Primitive

- Blue 900: `#0a1733`
- Blue 800: `#122a57`
- Blue 700: `#1a3f7a`
- Green 600: `#1d9a5a`
- Green 700: `#167847`
- Sand 50: `#f6f4ef`
- Sand 100: `#ece8e0`
- Stone 200: `#d8d5cd`
- Slate 500: `#5e6776`
- Ink 900: `#11161d`

### Semantic

- Canvas: `--surface-canvas`
- Card: `--surface-card`
- Muted surface: `--surface-muted`
- Strong surface: `--surface-strong`
- Primary text: `--text-primary`
- Secondary text: `--text-secondary`
- Brand primary: `--brand-primary`
- Brand accent: `--brand-accent`

## Spacing scale

- 2XS: `0.25rem`
- XS: `0.5rem`
- SM: `0.75rem`
- MD: `1rem`
- LG: `1.5rem`
- XL: `2rem`
- 2XL: `3rem`
- 3XL: `4rem`
- 4XL: `5rem`
- 5XL: `6.5rem`

## Radius and depth

- Small radius: `6px`
- Standard radius: `8px`
- Cards and panels should not exceed `8px`
- Shadows stay soft and structural, never decorative

## Component principles

- Buttons are compact, dense, and clearly directional
- Cards are used only where the content genuinely needs containment
- Section layouts should read as bands, not stacks of floating cards
- Overlines and mono labels are used with restraint
- CTA hierarchy stays obvious: primary action, then support action

## Implementation notes

- Global token reset begins in `style.css`
- Theme font loading is controlled from `functions.php`
- Future spacing refinement should be verified page by page in-browser after the new system settles
