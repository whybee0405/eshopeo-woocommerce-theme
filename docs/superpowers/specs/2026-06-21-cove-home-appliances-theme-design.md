# COVE Home Appliances — WooCommerce Theme Design Spec

**Date:** 2026-06-21
**Branch target:** `feat/cove-theme`
**Reference themes:** `digicars-theme` (structure, taxonomies, admin importer, faceted catalogue), `kbeauty-theme` (full cart/checkout, Three.js 3D, GSAP animations, importmap pattern)

---

## 1. Brand Identity

### Name & Positioning
**Brand:** COVE
**Tagline:** "Home, done right."
**Sub-line:** "New and certified demo appliances for every room."
**Market position:** Value-forward with a premium, modern aesthetic. Not luxury — honest, approachable confidence. Sells both new stock and 3-tier certified demo/b-stock (Grade A / B / C).

### Brand Voice
Direct, honest, quietly confident. Never corporate. The b-stock story is told as transparency, not apology. Example copy tone: *"This coffee machine has a small scratch on the base. You won't care. Your morning will."*

### Colour Palette
```css
--cream:       #F7F4EE;   /* warm off-white base */
--cream-deep:  #EDE9DF;   /* sunken / alt surface */
--slate:       #252830;   /* deep warm charcoal — dark surfaces, body text */
--slate-soft:  #363B47;   /* raised dark surface */
--amber:       #E07B35;   /* signature accent — CTAs, active states, highlights */
--amber-deep:  #C4621F;   /* pressed / hover amber */
--sand:        #BFB4A2;   /* warm muted decoration */
--muted:       #78726A;   /* secondary text */
--line:        #DDD8CE;   /* borders on light surfaces */
--line-dark:   rgba(247,244,238,0.12); /* borders on dark surfaces */
```

### Condition Grade Colour Coding
| Grade | Colour | Meaning |
|---|---|---|
| New | `--amber` | Brand new, unwrapped |
| Grade A | `#2DB89A` (teal) | Open box / near-perfect demo |
| Grade B | `#4A8FD4` (blue) | Minor cosmetic marks, fully functional |
| Grade C | `--sand` | Visible cosmetic damage, maximum discount |

### Typography
- **Display:** Fraunces (variable weight serif — warm, editorial)
- **Body:** Plus Jakarta Sans (clean, legible, friendly)
- **Mono:** DM Mono (prices, specs, grade badges, counts)
- **Google Fonts URL:** `family=Fraunces:opsz,wght@9..144,300..900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap`

### Logo
Wordmark `COVE` set in Plus Jakarta Sans Bold, wide letter-spacing. Monogram mark: a simple arch/cove arc for favicon and product stamps. Inline SVG in `header.php`.

---

## 2. Target Personas

### Persona 1 — The Nest Builder (primary)
- **Age:** 25–34, renting or first home
- **Goal:** Outfit their home fast, on a real budget
- **Behaviour:** Mobile-first, fast decisions, drawn to Grade B/C savings
- **Journey:** Homepage → category tile → condition filter → product → cart
- **Key need:** Trust signals immediately visible; clear grade explanation

### Persona 2 — The Savvy Upgrader
- **Age:** 35–50, established household
- **Goal:** Replace/upgrade a specific appliance, knows what they want
- **Behaviour:** Desktop, reads specs, compares, open to Grade A if saving is meaningful
- **Journey:** Search or direct category → filter brand/feature → PDP → cart
- **Key need:** Full specs, honest grade notes, warranty clarity

### Persona 3 — The Gift / Urgent Buyer
- **Age:** Any
- **Goal:** One specific item, fast
- **Behaviour:** Search-driven, price-sensitive but needs quick confidence
- **Journey:** Homepage → search → PDP → cart
- **Key need:** Clear pricing, clear condition, fast checkout path

---

## 3. UX Principles

1. **Grade is never hidden.** Condition badge visible on every product card and above the fold on every PDP.
2. **Grades explained once, everywhere.** Tooltip or inline explainer on every badge links to `/grades`.
3. **Savings shown explicitly.** RRP crossed out + "Save R X" badge on all graded products. Regular price = RRP; sale price = COVE price.
4. **Category-first navigation.** Primary nav: Kitchen · Laundry · Climate · Floor Care · Personal Care · Deals.
5. **Mobile cart is first-class.** Sticky add-to-cart bar on PDP; cart accessible from fixed header on all breakpoints.
6. **Trust earned in first scroll.** Grade explainer, warranty line, returns policy all visible before the second section on homepage.

---

## 4. Site Structure

### Navigation
- **Notice bar** (above header): rotating trust messages
- **Primary nav:** Kitchen · Laundry · Climate · Floor Care · Personal Care · Deals
- **Header right:** search icon · cart icon (with item count) · hamburger (mobile)
- **Footer nav:** Shop categories · About · Grades · FAQ · Contact · Blog · Returns Policy

### Page Inventory

| File | Route | Purpose |
|---|---|---|
| `front-page.php` | `/` | Homepage |
| `archive-product.php` | `/shop` | Catalogue with faceted filters |
| `single-product.php` | `/product/{slug}` | Product detail page |
| `woocommerce/content-product.php` | — | Product card partial |
| `page-about.php` | `/about` | Brand story, b-stock sourcing |
| `page-grades.php` | `/grades` | Grade A/B/C explainer page |
| `page-faq.php` | `/faq` | Shipping, returns, warranty FAQ |
| `page-contact.php` | `/contact` | Contact form |
| `index.php` / `single.php` | `/blog` | The COVE Edit (buying guides) |
| `header.php` | — | Global header |
| `footer.php` | — | Global footer |
| `404.php` | — | Error page |
| `searchform.php` | — | Search form partial |
| `inc/admin-import.php` | WP Admin | Demo data importer (Appearance > Import Demo Data) |
| `inc/seo.php` | — | Structured data / SEO helpers |

### Custom Taxonomies (on `product`)
| Taxonomy | Slug | Terms |
|---|---|---|
| `product_cat` (built-in WC) | — | Kitchen, Laundry, Climate, Floor Care, Personal Care |
| `product_condition` | `condition` | new, grade-a, grade-b, grade-c |
| `product_brand` | `brand` | Hisense, Samsung, LG, Bosch, KIC, Defy, Russell Hobbs, etc. |

### Custom Product Meta
| Key | Type | Purpose |
|---|---|---|
| `_cove_brand` | string | Brand display name |
| `_cove_rrp` | number | Recommended retail price (for savings display) |
| `_cove_energy_rating` | string | A+++, A++, A+, A, B, C, D |
| `_cove_colour` | string | Colour name |
| `_cove_warranty` | string | e.g. "2 years" / "90 days" |
| `_cove_grade_notes` | string | Plain-language cosmetic description for Grade A/B/C |
| `_cove_dimensions` | string | W × D × H in mm |
| `_cove_weight` | number | kg |
| `_cove_saving` | number | Computed RRP − sale price (set by importer + save action); enables "Biggest saving" sort via meta_value_num |

---

## 5. Homepage Section Order (`front-page.php`)

The section order is the customer journey.

1. **Notice Bar** — rotating ticker: free shipping threshold · grade explainer link · returns policy
2. **Hero — Room Environment** (Three.js) — full-viewport warm room scene, products as hot spots, mouse parallax, headline + 2 CTAs, static SVG fallback on mobile
3. **Shop by Category** — 5 icon tiles (Kitchen, Laundry, Climate, Floor Care, Personal Care)
4. **New Arrivals** — 4-column grid, latest 8 published products
5. **The Grade Strip** — dark slate section, 3 columns (Grade A / B / C), honest plain-English description per grade, saving range, "Browse Grade X" CTA
6. **Featured Deals** — 3-column grid of hand-picked Grade A/B products, RRP crossed out, savings badge
7. **Trust Bar** — 4 icon + text blocks: warranty · tested & certified · 30-day returns · free shipping threshold
8. **Reviews** — 1 large hero review + 2 stacked. Reviews reference specific grade purchases.
9. **The COVE Edit (Blog)** — 3-column blog card grid, buying guides
10. **Closing CTA** — dark slate band: *"Great appliances shouldn't cost the earth."* + "Shop All Products" + "Learn About Our Grades"

---

## 6. Key Page Designs

### Product Card (`content-product.php`)
- Square-cropped product image
- Condition badge top-left (colour-coded per grade)
- Brand name (muted, small) above product title
- RRP crossed out + sale price in amber (for graded items)
- "Save R X" badge (amber, small)
- "Add to Cart" button (full-width, amber)

### Product Detail Page (`single-product.php`)
**Left column — Gallery:**
- Main image with thumbnail strip below
- "View 3D" toggle button → reveals Three.js canvas (OrbitControls, 360° rotation)
- Falls back gracefully if WebGL unavailable

**Right column — Info:**
- Brand eyebrow
- Product title (Fraunces display)
- Condition badge + grade notes (the honest cosmetic description, shown for Grade A/B/C only)
- Price: RRP crossed out + COVE price in amber + "Save R X"
- Warranty line (icon + text)
- Add to Cart button (sticky on scroll, appears in fixed bottom bar)
- Quantity selector
- Accordions: Full Specs (energy rating, dimensions, colour, weight) · Warranty Detail · Returns Policy

**Below fold:** Related products from same category (4 cards)

### Catalogue (`archive-product.php`)
**Sidebar filters:**
- Category (checkboxes)
- Condition Grade (colour-coded checkboxes: New / Grade A / Grade B / Grade C)
- Price range (dual-handle slider)
- Brand (checkboxes)
- Energy rating (checkboxes)

**Grid:** 3-col desktop · 2-col tablet · 1-col mobile
**Sort:** Newest · Price low–high · Price high–low · Biggest saving
**Active filter chips** shown above grid, each dismissible

### Grades Page (`page-grades.php`)
Three columns explaining each grade with:
- Honest description of what cosmetic condition to expect
- What's checked/tested before listing
- Warranty included
- Example saving range
- "Browse Grade X" CTA

---

## 7. WooCommerce Configuration

- **Cart + checkout: fully enabled** (no cart disable filters — opposite of Digicars)
- WooCommerce built-in CSS disabled — theme ships complete WC styles in `css/woocommerce.css`
- Sale price = COVE selling price; regular price = RRP (enables WC native savings display)
- `loop_shop_per_page`: 12 products
- `loop_shop_columns`: 1 (theme CSS grid controls visual columns)
- WC default sidebar removed
- WC result count + catalog ordering removed (theme renders custom controls)
- Breadcrumb delimiter: ›
- Image size: `cove-card` at 600×600 cropped

### Faceted Catalogue Filters (`pre_get_posts`)
GET params consumed:
- `condition` → `product_condition` taxonomy
- `brand` → `product_brand` taxonomy
- `cat` → `product_cat` taxonomy
- `price_min` / `price_max` → WC `_price` meta
- `energy` → `_cove_energy_rating` meta
- `orderby` → price / price-desc / date / saving

---

## 8. 3D & Animation Plan

### Hero Room Scene (`js/hero-room.js`)
- `type="module"`, loaded on front page only via importmap
- Three.js scene: low-poly warm room (walls, floor, counter, shelving), flat-shaded geometry, amber point lights
- 5–7 product hot spots (invisible raycaster targets): coffee machine, air purifier, vacuum, washing machine, kettle
- Hover interaction: amber point light pulse + CSS-positioned product card (name, grade badge, price, "Shop Now")
- Mouse parallax: camera rotates ±3° on mousemove around fixed pivot
- Mobile: canvas hidden, static SVG hero shown
- Fallback: if WebGL unavailable, static image shown silently
- `requestAnimationFrame` loop paused on `document.visibilitychange`

### PDP 3D Viewer (`js/pdp-3d.js`)
- `type="module"`, loaded on single product only
- OrbitControls: full 360° rotation
- Per-category placeholder mesh (box=washing machine, cylinder=coffee machine, rounded box=air purifier, etc.) with warm PBR material
- If `_cove_3d_model` meta provides a `.glb` URL, loads that instead
- "View 3D" toggle button: same UX as Glow K-Beauty

### Importmap (in `functions.php` `wp_head`, front page + single product)
```json
{"imports":{"three":"https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js","three/addons/":"https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"}}
```

### GSAP + ScrollTrigger (CDN, all pages)
| Element | Animation |
|---|---|
| Section headings | Fade up + Y translate on viewport enter |
| Product cards | Staggered fade-up, 60ms between cards |
| Grade strip columns | Slide in from alternating sides |
| Trust bar | Counter tick-up on numbers |
| Category tiles | Scale 0.95 → 1 on enter |
| Review cards | Sequential fade-in |
| Hero headline | Word-by-word reveal on load |
| Notice bar ticker | CSS `animation: marquee` (no GSAP) |

### Reduced Motion
All GSAP animations wrapped in `matchMedia('(prefers-reduced-motion: reduce)')` — instant show, no transforms. Three.js renders but autorotation disabled.

---

## 9. JavaScript Files

| File | Loaded on | Purpose |
|---|---|---|
| `js/main.js` | All pages | Mobile menu, notice bar ticker, reveal observer, cart icon count, toast |
| `js/scroll-animations.js` | All pages | GSAP + ScrollTrigger reveal animations |
| `js/hero-room.js` | Front page | Three.js room environment hero |
| `js/pdp-3d.js` | Single product | Three.js PDP orbital viewer |
| `js/filters.js` | Catalogue | Filter sidebar toggle (mobile drawer), active chip dismissal, price slider |

---

## 10. Admin Demo Importer

Same pattern as Digicars `inc/admin-import.php`:
- Appearance > Import Demo Data menu page
- Inserts ~20 dummy products across all categories and all 4 conditions (New, Grade A, Grade B, Grade C)
- Sets `_sale_price` and `_regular_price` on graded items to demonstrate savings display
- Populates all custom meta fields
- Idempotent (checks for existing products before inserting)

---

## 11. SEO (`inc/seo.php`)

- `<title>` pattern: `{Product Name} — {Grade} | COVE`
- Open Graph tags on product pages
- `Product` JSON-LD schema on PDP including `offers`, `sku`, `brand`
- `ItemCondition` mapped: New → `NewCondition`, Grade A → `RefurbishedCondition`, Grade B/C → `UsedCondition`
- Canonical URLs on catalogue pages with filter params

---

## 12. File / Folder Structure

```
cove-theme/
├── style.css                  # Theme header + full design system
├── functions.php              # Theme setup, taxonomies, meta, WC config, AJAX, helpers
├── front-page.php
├── header.php
├── footer.php
├── index.php
├── single.php
├── archive-product.php
├── single-product.php
├── page.php
├── page-about.php
├── page-grades.php
├── page-faq.php
├── page-contact.php
├── 404.php
├── searchform.php
├── dummy-products.php
├── css/
│   └── woocommerce.css
├── js/
│   ├── main.js
│   ├── scroll-animations.js
│   ├── hero-room.js
│   ├── filters.js
│   └── pdp-3d.js
├── images/
│   ├── hero/
│   │   ├── hero-room.svg        # Static fallback for hero
│   │   └── favicon.svg
│   ├── icons/
│   │   ├── cat-kitchen.svg
│   │   ├── cat-laundry.svg
│   │   ├── cat-climate.svg
│   │   ├── cat-floorcare.svg
│   │   └── cat-personal.svg
│   └── products/               # Placeholder product images
├── woocommerce/
│   └── content-product.php
├── inc/
│   ├── admin-import.php
│   └── seo.php
└── languages/
```

---

## 13. Constraints & Non-Goals

- No Elementor integration (unlike Glow K-Beauty) — COVE is hardcoded theme only
- No enquiry/lead capture form on PDP (full cart/checkout instead)
- No finance calculator (not relevant to appliances)
- No AI Concierge matcher (not in scope for v1)
- No `.glb` 3D model files shipped with theme — placeholder meshes used until client uploads real models
- South African market (ZAR pricing, SA-relevant brands)
