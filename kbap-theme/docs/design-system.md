# K-BAP Design System

## Design Direction

K-BAP should feel like Muji, Aesop, Sweetgreen, Marugame Udon, and Apple met around a Korean catering table in South Africa. The site is minimal, warm, authentic, premium, natural, and honest.

The design must not feel like luxury hospitality, fast food, K-pop, anime, neon, or generic "Asian" styling. Food is the hero.

## Scene

A customer is planning an event from a laptop or phone in daylight. They need to understand the food, trust the caterer, and imagine the table. The interface should feel calm and practical, with enough warmth to make the food desirable.

## Colour Tokens

| Token | Hex | Use |
| --- | --- | --- |
| Seaweed | `#231F20` | Primary text, primary buttons, logo outer section |
| Rice | `#FAF7F2` | Page background, light surfaces |
| Kimchi | `#F25B3C` | Food accent, selected states, limited highlights |
| Perilla | `#58A64B` | Fresh accent, product notes, secondary highlights |
| Sesame | `#9B6546` | Warm secondary text, packaging accents |
| Warm Grey | `#E8E5E0` | Borders, dividers, quiet surfaces |

Rules:

- Use Rice as the main surface.
- Use Seaweed for most text and primary actions.
- Use Kimchi sparingly, under 10 percent of a page.
- Use Perilla and Sesame as supporting accents only.
- Do not use gradients.
- Do not use pure white or pure black.

## Typography

| Role | Font | Notes |
| --- | --- | --- |
| Headings | Manrope | 600 to 800 weight, generous line-height |
| Body | Inter | 400 to 600 weight, readable at mobile sizes |
| Fallback | System sans-serif | Use if web fonts fail |

Rules:

- Headings should be large but not theatrical.
- Body line length should stay near 65 to 75 characters.
- Avoid decorative fonts.
- Avoid all-caps body text.
- Use labels sparingly.

## Type Scale

| Token | Size |
| --- | --- |
| Display | `clamp(3rem, 8vw, 7rem)` |
| H1 | `clamp(2.5rem, 6vw, 5.5rem)` |
| H2 | `clamp(2rem, 4vw, 3.5rem)` |
| H3 | `1.35rem` to `1.75rem` |
| Body | `1rem` to `1.075rem` |
| Small | `0.875rem` |

## Spacing

Use an 8px base scale.

| Token | Value |
| --- | --- |
| 1 | 4px |
| 2 | 8px |
| 3 | 12px |
| 4 | 16px |
| 5 | 24px |
| 6 | 32px |
| 7 | 48px |
| 8 | 64px |
| 9 | 96px |
| 10 | 128px |

Rules:

- Use large section spacing.
- Keep related items close.
- Avoid equal padding everywhere.
- Let whitespace separate ideas before adding borders.

## Grid

- Max content width: 1180px.
- Wide media width: 1440px.
- Desktop grid: 12 columns.
- Tablet grid: 6 columns.
- Mobile grid: 4 columns.
- Use one dominant idea per section.

## Radius

| Token | Value | Use |
| --- | --- | --- |
| Button | 12px | Buttons, small controls |
| Card | 16px | Cards, product cards, forms |
| Media | 18px | Food photography |
| Round | 999px | Only tiny counters or avatar-like marks |

## Elevation

Use soft shadows only when a surface needs separation.

| Token | Value |
| --- | --- |
| Soft | `0 18px 45px rgba(35, 31, 32, 0.08)` |
| Lifted | `0 28px 70px rgba(35, 31, 32, 0.12)` |

Avoid heavy shadows, glow effects, and floating decorative panels.

## Components

### Buttons

- Primary: Seaweed background, Rice text.
- Secondary: Rice background, Seaweed text, Warm Grey border.
- Accent: Kimchi background only for limited conversion moments.
- Radius: 12px.
- Active state: subtle `scale(0.97)`.
- Hover: small color or transform change only on hover-capable devices.

### Cards

- Radius: 16px.
- Background: Rice or a slightly warmer surface.
- Shadow: soft, only when needed.
- No nested cards.
- Food images should carry the visual weight.

### Forms

- Rounded inputs.
- Labels always visible.
- Clear focus state.
- Error text near the field.
- No placeholder-only labels.

### Navigation

- Simple primary nav.
- Avoid excessive icons.
- Cart count should be quiet and readable.
- Mobile menu should be direct and keyboard accessible.

### Menu Items

- Dish name first.
- Short description second.
- Price or quote status aligned consistently.
- Tags only when useful: vegetarian, spicy, catering, market, future product.

### Product Cards

- Product photo.
- Product type or family.
- Name.
- Short description.
- Price or quote status.
- Add to cart or enquiry action.

## Photography

Use natural lighting, wood, stone, ceramic, and warm food styling. Avoid stock-like scenes, fake steam, HDR, dark moody crops, plastic-looking food, and generic Korean visual tropes.

Photography should show:

- Catering tables.
- Close food texture.
- Kimchi jars.
- Meal kit ingredients.
- Hands placing food when useful.
- South African event context without making the styling noisy.

## Illustration And Patterns

Use almost no illustration. When needed, use quiet linework derived from the gimbap-slice logo geometry or simple packaging marks.

No decorative waves, neon shapes, cherry blossoms, anime motifs, or generic Asian patterning.

## Motion

Allowed:

- Fade.
- Slide.
- Scale.
- 200ms default duration.
- Custom ease-out curve.

Rules:

- Animate only transform and opacity.
- No bounce.
- No elastic.
- Respect `prefers-reduced-motion`.
- Avoid animation on repeated keyboard actions.

## Accessibility

- WCAG AA minimum.
- Visible focus states.
- Semantic headings.
- Keyboard navigation.
- Alt text for all meaningful images.
- ARIA only where semantic HTML is not enough.
- Contrast must be tested against Rice and Seaweed surfaces.

## Implementation Tokens

The WordPress theme should expose these CSS custom properties before page-level styling:

```css
--color-seaweed: #231F20;
--color-rice: #FAF7F2;
--color-kimchi: #F25B3C;
--color-perilla: #58A64B;
--color-sesame: #9B6546;
--color-warm-grey: #E8E5E0;
--font-heading: "Manrope", system-ui, sans-serif;
--font-body: "Inter", system-ui, sans-serif;
--radius-button: 12px;
--radius-card: 16px;
--duration-fast: 120ms;
--duration-base: 200ms;
--ease-out: cubic-bezier(0.23, 1, 0.32, 1);
```

