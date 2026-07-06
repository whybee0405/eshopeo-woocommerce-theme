# K-BAP WooCommerce Theme

K-BAP is a catering-first WooCommerce theme for a South African Korean food brand. It supports the current catering business and future online sales for K-BAP Kimchi, meal kits, sauces, pantry items, market drops and catering packs.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- WooCommerce 8.0+

## Setup

1. Upload and activate `kbap-theme`.
2. Activate WooCommerce.
3. Create pages and assign templates:
   - Home: set as static front page
   - Menu: template "Menu"
   - Catering: template "Catering"
   - About: template "About"
   - Contact: template "Contact"
   - FAQ: template "FAQ"
4. Import demo products:

```bash
wp eval-file wp-content/themes/kbap-theme/dummy-products.php
```

The importer creates product examples for K-BAP Kimchi, Korean fried chicken trays, gimbap platters, samgak gimbap boxes, tteokbokki trays, japchae, bulgogi meal kits, short rib stew kits and an office lunch catering package.

## Theme Files

- `functions.php`: setup, assets, menu data, catering package data, WooCommerce metadata, AJAX enquiry.
- `front-page.php`: catering-led homepage.
- `page-menu.php`: SEO-friendly HTML menu page.
- `page-catering.php`: packages, process and enquiry.
- `inc/seo.php`: meta tags and JSON-LD for organization, website, menu, product and FAQ.
- `dummy-products.php`: idempotent WooCommerce demo importer.
- `css/woocommerce.css`: shop and product styles.
- `js/main.js`: mobile menu, reveals, menu nav state and enquiry form.

## Design Notes

The theme is food-led and modern, with Korean detail handled through structure, language cues and dish presentation rather than decorative cliches. Motion is restrained and respects reduced-motion preferences.
