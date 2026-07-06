# K-BAP Performance Plan

## Targets

- Lighthouse Performance: 100.
- Accessibility: 100.
- Best Practices: 100.
- SEO: 100.
- Core Web Vitals in the green.
- Minimal JavaScript.
- Fast image delivery.

## Current Risks

- PNG images are large, around 2MB to 2.8MB each.
- Google Fonts currently load more families than the new design system needs.
- CSS has page and component styling in one file.
- Reveal motion uses longer timings than the brief requires.
- WooCommerce pages can load extra assets.

## Image Plan

Actions:

- Compress all large PNGs.
- Generate WebP or AVIF variants where WordPress supports them.
- Define image dimensions to prevent layout shift.
- Use lazy loading for non-hero images.
- Keep the hero image high quality but optimized.
- Avoid using the same large image in too many contexts.

## Font Plan

Actions:

- Load only Manrope and Inter.
- Limit weights to required ranges.
- Use `font-display: swap`.
- Consider local font hosting if performance requires it.

## CSS Plan

Actions:

- Convert current palette to design tokens.
- Remove gradients and backdrop blur.
- Remove unused or duplicated styles.
- Avoid `transition: all`.
- Keep WooCommerce CSS lean.
- Use responsive CSS without excessive breakpoints.

## JavaScript Plan

Actions:

- Keep vanilla JavaScript.
- Avoid adding animation libraries to the WordPress theme.
- Keep reveal animation optional and reduced-motion aware.
- Make mobile menu accessible and lightweight.
- Do not block rendering with non-critical scripts.

## WooCommerce Plan

Actions:

- Avoid unnecessary shop widgets.
- Keep cart and checkout templates simple.
- Reduce visual clutter from notices.
- Test empty cart, single item cart, and checkout errors.

## Caching

Recommended production setup:

- Page caching for public pages.
- Browser caching for static assets.
- CDN where available.
- Object caching if WooCommerce traffic grows.

## Accessibility Checks

Run checks for:

- Contrast.
- Keyboard navigation.
- Focus states.
- Form labels.
- Alt text.
- Reduced motion.
- Heading order.

## QA Checklist

Before release:

- Run PHP syntax checks.
- Run JavaScript syntax check.
- Test homepage, menu, catering, shop, product, cart, checkout, account, search, 404.
- Test mobile and desktop.
- Test with WooCommerce active.
- Test graceful behaviour when WooCommerce is inactive.
- Run Lighthouse.
- Update Graphify memory.

