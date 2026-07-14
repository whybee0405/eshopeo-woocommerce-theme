# Parts-Mall — WooCommerce theme

A branch-led WooCommerce catalogue theme for **Parts-Mall Africa**. Products are automotive parts, but **cart and checkout are disabled** — the site is built for search, branch stock checks, trade enquiries and agent lead generation.

---

## What's included

- **Homepage journey** — catalogue-first hero, category routing, make strip, network proof, private brands, agent teaser and featured parts.
- **Faceted catalogue** (`archive-product.php`) — category, make, private brand and availability filters with a mobile drawer.
- **Single part detail** (`single-product.php`) — branch-led CTAs, part number / OEM fields, compatibility, warranty framing and related parts.
- **Network pages** — Find a Branch, Become an Agent, About and Contact templates.
- **SEO** — persona-driven meta tags plus JSON-LD for Organization, WebSite + SearchAction, Product, BreadcrumbList and FAQPage.
- **Bundled seeders** — demo parts (`dummy-products.php`) and real branch directory structure (`dummy-branches.php`).

## Design system

- **Palette:** navy `#0F2F73`, navy-deep `#081B47`, emerald `#0F9D58`, steel `#5B6472`, paper `#F5F6F8`.
- **Type:** Barlow Condensed (display), Archivo (body/UI), JetBrains Mono (data/spec voice).
- **Motion:** restrained scroll reveals and hover lifts only, with global `prefers-reduced-motion` respect.
- **Layout:** 1280px container, tight 2/6/12px radii, branch-and-catalogue-first hierarchy.

---

## Installation

1. Zip the `parts-mall-theme` folder and upload it in **Appearance → Themes → Add New → Upload Theme**.
2. Ensure **WooCommerce** is active.
3. Import the demo catalogue and branch directory:
   ```bash
   wp eval-file wp-content/themes/parts-mall-theme/dummy-products.php
   wp eval-file wp-content/themes/parts-mall-theme/dummy-branches.php
   ```
4. Set a static front page named **Home** under **Settings → Reading**.
5. Create and assign these page templates:
   - **Find a Branch** → `Find a Branch`
   - **Become an Agent** → `Become an Agent`
   - **About** → `About`
   - **Contact** → `Contact`
6. Build primary and footer menus if you want to override the built-in fallbacks.

## REST / integration notes

- Every locked `_part_*` field is registered with `show_in_rest => true`, so the standard WordPress / WooCommerce REST APIs can read catalogue data without extra plugins.
- `partsmall_catalogue_search` returns `{count, ids, cards_html}` for the live search UI.
- `partsmall_enquiry` returns `{ok, message}` and is shared by the product modal, agent form and contact form.
- Branch data is stored in one option: `partsmall_branch_directory`.
- Dynamic branch pages are generated at `/branches/{branch-slug}/` from that same option. Add a new branch record with a stable `slug`, `name`, `address`, `phone`, optional `email`, `whatsapp`, `hours`, `map_query`, and optional `gallery` image array to spin up a page without creating a new template.

## Placeholder imagery

- The theme uses the bundled SVG assets in `images/`.
- Product templates fall back to `images/placeholders/part-default.svg` when no featured image is attached.
