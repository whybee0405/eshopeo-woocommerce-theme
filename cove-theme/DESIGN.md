# COVE Design System

## Position

COVE is a premium appliance outlet for new, open-box, demo, and graded stock. The brand is not a bargain bin and not a luxury fashion house. It should feel like a precise product showroom with direct condition evidence, calm commerce flows, and enough movement to feel alive without slowing the purchase.

## Brand Words

- Architectural
- Exact
- Warm-metallic

## Core Idea

**Inspection Passport** is the main trust pattern. Every meaningful product surface should answer four questions quickly: what grade is it, what was inspected, what cosmetic compromise exists, and what warranty protects me.

## Typography

Runtime typography uses a premium sans system:

- Display and UI: `Geist`
- Mono facts: `Geist Mono`
- Fallbacks: `Aptos`, `Segoe UI`, `system-ui`, `Consolas`

The old serif/display mix is retired. Appliance commerce should feel engineered, clean, and confident, not editorial.

## Color

- Warm off-white background: `#F8F5EF`
- Panel surface: `#FDFBF7`
- Deep graphite: `#23262D`
- Soft graphite: `#353A44`
- Conductive copper: `#B96A3C`
- Burnt copper: `#96512D`
- Grade A teal: `#208C75`
- Grade B blue: `#376FAD`
- Grade C clay: `#9C8871`

Use copper for action and savings only. Do not use amber as general decoration.

## Surface Rules

- Use fewer cards. Let large product media and rule-based layouts carry premium structure.
- Product cards may be framed because they are repeated commerce objects.
- Trust modules should use rows, lines, and panels rather than nested cards.
- Use tinted neutrals instead of pure black or pure white.

## Motion

- Button active feedback: `scale(0.97)` or `translateY(1px)`, 120-160ms.
- Drawers: 220-280ms, transform only, strong ease-out.
- Repeated commerce actions must feel instant.
- 3D and scroll motion must pause when hidden and respect reduced motion.
- Avoid decorative glassmorphism. Use a single refined blur only where it behaves like material, such as the sticky header.

## Commerce UX

1. Homepage should lead with a product theater and room/category paths.
2. Catalogue filters use single-select controls unless the query layer supports arrays.
3. PDP must expose Inspection Passport above the fold.
4. Sticky buy controls remain accessible and keyboard reachable.
5. Mobile layout prioritizes buy confidence: grade, price, warranty, add to cart.

## Copy

COVE speaks plainly. Name the scratch, name the saving, name the warranty. Avoid vague claims like "excellent condition" unless paired with evidence.
