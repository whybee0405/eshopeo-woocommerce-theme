# K-BAP Frontend Architecture

## Current Architecture

The current K-BAP website is a WordPress/WooCommerce PHP theme. It uses:

- PHP templates.
- WordPress theme functions.
- WooCommerce template overrides.
- CSS custom properties.
- A small vanilla JavaScript file.
- Generated raster imagery.

This should remain the production path for the current refactor.

## Strategic Decision

Do not rewrite the current website into Next.js during this refactor. The brief requires production stability, incremental work, and small commits. A full framework migration would increase risk and delay brand consistency work.

The Next.js architecture should be documented as a future headless storefront path, not used as the immediate implementation target.

## Immediate WordPress Theme Architecture

### Folders

```text
kbap-theme/
  css/
  docs/
  images/
  inc/
  js/
  template-parts/
  woocommerce/
```

### Template Responsibilities

- `front-page.php`: homepage narrative.
- `page-menu.php`: SEO-friendly menu.
- `page-catering.php`: catering packages and enquiry.
- `archive-product.php`: WooCommerce product listing.
- `single-product.php`: product detail.
- `template-parts/`: reusable PHP fragments.
- `inc/seo.php`: metadata and structured data.

## Component Strategy

Reuse before creating new components.

Document every reusable component in `design-system.md` before or during implementation.

Priority components:

- Button.
- Page hero.
- Section header.
- Food card.
- Product card.
- Package card.
- Menu section.
- Menu item.
- Trust block.
- Enquiry form.
- FAQ item.
- WooCommerce notice.
- Empty state.

## CSS Strategy

- Use design tokens first.
- Keep layout utilities small.
- Avoid one-off page hacks.
- Avoid `transition: all`.
- Avoid gradients and backdrop blur.
- Use CSS custom properties for theme values.
- Use class names that describe component purpose.

## JavaScript Strategy

Keep JavaScript minimal.

Allowed:

- Mobile menu.
- Menu category active state.
- Enquiry form enhancement.
- Subtle reveal animation.

Avoid:

- Heavy animation libraries in the WordPress theme.
- Scroll hijacking.
- Decorative motion that blocks interaction.

## Accessibility

- Use semantic HTML first.
- Keep form labels visible.
- Ensure mobile menu focus behaviour is correct.
- Keep focus states visible.
- Use ARIA only when needed.

## Performance

- Compress large PNGs.
- Prefer WebP or AVIF where WordPress supports it.
- Use `loading="lazy"` for non-critical images.
- Keep hero image optimized but visually strong.
- Load only required font weights.
- Keep CSS and JS small.

## Future Headless Architecture

If K-BAP later moves to a headless storefront, use:

- Next.js.
- TypeScript.
- TailwindCSS.
- Shadcn only where component semantics help.
- Framer Motion only for minimal 200ms fade, slide, and scale transitions.
- React Server Components for content-heavy routes.
- WooCommerce REST API or Store API for commerce.

### Future Folder Structure

```text
app/
  (site)/
  (shop)/
  api/
components/
  ui/
  commerce/
  content/
lib/
  woocommerce/
  seo/
  schema/
content/
public/
```

### Migration Rule

Only consider the Next.js migration after the WordPress theme has a stable brand system, content model, and product taxonomy.

