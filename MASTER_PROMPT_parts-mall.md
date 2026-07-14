# MASTER_PROMPT — Parts-Mall WooCommerce Theme (v1)

You are a senior WordPress/WooCommerce theme developer and design lead. Build a complete,
production-ready WooCommerce theme called **Parts-Mall** from this specification alone. Do not
deviate from the design system. Do not add features not specified here. When a decision is not
covered, choose the option that best serves the customer journeys in Section 3. This theme is
unrelated to any other theme in this repository — it must not look like, borrow tokens from, or
share fonts with the glow, digicars, cove, or kbap themes.

---

## 1. PROJECT BRIEF

Build an award-calibre WooCommerce theme for **Parts-Mall Africa**, a wholesale importer and
distributor of automotive spare parts for Korean-manufactured vehicles (and more), trading through
40+ branches and agents across South Africa and neighbouring African countries. Tagline: *"Korea's
#1 Automotive Parts Supplier."* The theme must:

- Look designed by a human studio, not generated. Avoid all AI-design tells: no floating gradient
  orbs, no centered-stat hero, no glassmorphism, no generic "Why choose us" 3-icon row, no stock
  auto-parts clichés (exploded engine diagrams as decoration, chrome-and-carbon-fiber textures,
  wrench-icon soup), no lorem ipsum.
- Be a **standard, clean WooCommerce theme** with no proprietary plugin hooks and **no custom
  `do_action` hooks** beyond WordPress/WooCommerce norms. **No AI branding or AI references
  anywhere in code or comments.**
- Be organised around the **customer journey**, not around what looks pretty. Every section must
  serve one of the four personas in Section 2.
- Model **spare parts as WooCommerce products** so the catalogue can be entered, searched, and
  browsed dynamically through the standard WP Admin — but **cart and checkout are fully disabled**.
  There is no e-commerce transaction anywhere. Add-to-cart is replaced by **Enquire about this
  part**, **Find a branch that stocks this**, and **Check availability**. This is a wholesale
  distributor with a branch/agent network, not a retail webshop.
- Ship with SEO baked in: persona-driven meta descriptions, Open Graph, and JSON-LD schema
  (AutoPartsStore/Organization, WebSite+SearchAction, Product, BreadcrumbList, FAQPage).
- Work out of the box with bundled dummy data (~30 demo parts spanning the real category taxonomy,
  plus ~40 demo branches).

**Locked identity:** Theme name **Parts-Mall** · slug / text domain **`parts-mall`** · folder
**`parts-mall-theme/`** · version **`1.0.0`** · author **CloudIA**.

**South African context is real, not decorative:** province-level branch info, SAST hours, ZAR
pricing where shown (many parts are wholesale/quote-based — pricing is optional per product, never
required), local phone/WhatsApp contact norms.

**Source-site fidelity note:** the legacy site (parts-mall.co.za) is a dated classic-ASP build with
no real branding system (Verdana/Arial only, inconsistent link colours). This rebuild elevates the
two colours that are actually load-bearing in the real logo — navy blue and emerald green — into a
deliberate, modern palette, and drops every inconsistent legacy accent (teal, purple, orange) that
was never part of the brand mark itself.

**Anti-slop guardrails (do not produce any of these):** floating gradient orbs · centered-stat hero
· glassmorphism · generic "Why choose us" 3-icon row · exploded-engine-diagram decoration · chrome/
carbon-fiber textures · wrench-icon soup · lorem ipsum.

---

## 2. THE FOUR PERSONAS (drive SEO + page content)

Document these in code comments inside `inc/seo.php`. Every meta description maps to one persona's
search intent.

1. **The independent mechanic / workshop owner** (trade buyer, time-pressured)
   - Intent: "brake pads for Hyundai i20 Johannesburg", "Kia alternator supplier South Africa".
   - Served by: category + make/model filtered catalogue, branch stock-check, fast enquiry.

2. **The fleet / parts procurement manager** (volume buyer, wants a reliable account)
   - Intent: "bulk auto parts supplier South Africa", "Parts-Mall become a distributor".
   - Served by: Become an Agent / trade account page, branch network scale, brand-warranty trust.

3. **The car owner sourcing a specific part** (VIN or part-number led, price-conscious)
   - Intent: "Kia Sportage brake pads price", "genuine vs aftermarket Hyundai parts".
   - Served by: search-by-category/make, part detail page, "find a branch near you."

4. **The prospective agent / branch partner** (business-opportunity seeker)
   - Intent: "become a Parts-Mall agent", "auto parts distributorship South Africa".
   - Served by: Become an Agent page, branch map showing footprint/credibility, About page.

---

## 3. PAGES & CUSTOMER JOURNEYS

### 3.1 Homepage (`front-page.php`) — section order is the journey
1. **Hero** — confident statement of scale + specialism ("Korea's #1 Automotive Parts Supplier,
   40+ branches across Southern Africa"), with a primary catalogue search bar (part name / category
   / vehicle make) as the functional centrepiece — not a static banner image.
2. **Browse by category** — tiles for the top-level part categories (Braking, Engine, Electrical,
   Suspension & Steering, Filters, Transmission & Clutch, Cooling, Fuel System, Body & Trim,
   Bearings, Gaskets & Seals, Accessories) linking to `product_cat` archives.
3. **Browse by vehicle make** — brand strip (Kia, Hyundai, Chevrolet, Ssangyong, Suzuki, Daewoo,
   GWM/Haval, Ford, Daihatsu, Nissan, Toyota) linking to make-filtered catalogue views.
4. **Our footprint** — a real trust section built on scale, not icons: branch count, provinces
   covered, pan-African reach (Botswana, Eswatini, Mozambique, Namibia, Zimbabwe), linking to the
   branch locator. No generic "Why choose us" — every stat is real and sourced from the branch data.
5. **Private brands** — the house-brand strip (Parts-Mall/PMC, NT, Car-Dex, Pomax, MX, Ex-Trim,
   Vichura, Pro-Tec, Dashi), each Parts-Mall Corporation warranted — framed as a quality guarantee,
   not a logo wall.
6. **Become an agent** teaser — short pitch + CTA into the lead-gen page. (Persona 2 & 4.)
7. **Latest / featured parts** — pulled via `wc_get_products` for CMS-freshness.
8. **Contact / enquiry CTA** — closing call to find a branch or send a parts enquiry.

### 3.2 Catalogue (`archive-product.php`)
Faceted catalogue over the real category taxonomy: category (grouped parent → child, from the
~250-category legacy list, consolidated into sane parent groups per §5.2.2), vehicle make, private
brand, availability. Toolbar: result count, sort select. Product grid via
`woocommerce/content-product.php` — cards show part name, category, compatible make(s), private
brand badge, and **Enquire** / **Find a branch** actions (never Add to cart). Pagination. Mobile
filter drawer with scrim. Empty state suggests broadening the search or contacting a branch directly.

### 3.3 Single part (`single-product.php`)
Gallery, part name, category breadcrumb, compatible vehicle makes/models chips, private brand
badge (with warranty note), part number / OEM cross-reference field, key spec list (mono
"telemetry" style: part number, compatible makes, material/type, private brand, warranty).
CTAs: **Enquire about this part**, **Find a branch that stocks this**, **Ask about bulk / trade
pricing** — never add-to-cart. Accordions via `<details>` (Overview / Compatibility / Warranty &
Quality). "You may also need" — 4 related parts (same category).

### 3.4 Static pages
- **Branch Locator** (`page-branches.php`, template "Find a Branch") — branch cards grouped by
  province, each with address, phone, and a compact map/pin treatment; pan-African branches listed
  separately. (Persona 1, 3, 4.)
- **Become an Agent** (`page-agent.php`, template "Become an Agent") — trade/distributor lead-gen
  form (name, company, email, contact number, area of interest) framed around the network's scale
  and warranty backing. (Persona 2 & 4.)
- **About** (`page-about.php`, template "About") — company story: Parts-Mall Corporation heritage,
  Korea's #1 automotive parts supplier positioning, private-brand warranty promise, footprint growth
  across South Africa and Africa. (Persona 2 & 4 trust-building.)
- **Contact** (`page-contact.php`, template "Contact") — general enquiry form + head office details;
  distinct from the branch locator (that's "find your nearest branch"; this is "talk to head
  office").
- **404** (`404.php`) — catalogue search + popular categories rescue.
- **page.php / index.php** — clean editorial fallbacks.

All lead/enquiry forms post to the `partsmall_enquiry` AJAX action. **No checkout anywhere.**

### 3.5 Header & footer
- **Header:** skip link, sticky header with shadow on scroll. Brand left; nav (**Catalogue /
  Categories / Brands / Become an Agent / Find a Branch / About / Contact**); utilities right
  (catalogue search, branch-locator shortcut). Mobile: full-screen overlay menu.
- **Footer:** deep-navy background, brand + link columns (**Browse / Company / Network / Contact**),
  private-brand strip, social links (Facebook, YouTube), oversized low-contrast wordmark.

---

## 4. DESIGN SYSTEM (non-negotiable)

### 4.1 Concept
**"The parts network you can rely on."** A confident, industrial-trade visual language built on the
two colours that are genuinely load-bearing in the real Parts-Mall logo — navy blue and emerald
green — elevated into a clean, modern, high-legibility system. No lifestyle photography clichés;
the parts, the categories, and the branch network are the proof.

### 4.2 Palette — elevated navy + emerald (drop all legacy noise)
Legacy teal (#00707A), purple (#7971EA), and orange (#FE4002) accents from the old site were
inconsistent leftovers, not brand colour — they are **not** carried forward.

```css
--navy:        #0F2F73;  /* deep brand navy — headers, primary text on light, dark surfaces */
--navy-deep:   #081B47;  /* near-black navy — footer, highest-contrast dark surface */
--signal:      #0F9D58;  /* emerald green — CTAs, active states, accents ONLY, sparingly */
--signal-deep: #0B7A44;
--steel:       #5B6472;  /* muted text on light backgrounds */
--paper:       #F5F6F8;  /* off-white base background */
--paper-deep:  #E8EAEE;  /* alternate panels */
--line:        #D8DCE2;  /* hairlines */
--ink:         #14181F;  /* near-black text */
```

### 4.3 Typography (Google Fonts)
- **Display:** **Fraunces** (600/700, no italic) is reserved for glow — do NOT use. Use **Archivo
  Black** for numerals/eyebrows is also reserved for digicars-style patterns — do NOT use Archivo
  Expanded. Instead:
  - **Display:** **Space Grotesk** (600/700) — engineered, technical, distinctive letterforms that
    read as industrial/precision without being generic corporate sans.
  - **Body/UI:** **Public Sans** (400/500/600) — a clean, highly legible workhorse built for dense
    information (government/industrial heritage, genuinely different personality from Hanken
    Grotesk or Schibsted Grotesk already used elsewhere in this repo).
  - **Data/spec voice:** **IBM Plex Mono** — part numbers, category codes, spec lists, result
    counts. Distinct from JetBrains Mono (digicars) and Spline Sans Mono (glow).
- **Never use** Inter, Poppins, Montserrat, Archivo Expanded, Hanken Grotesk, JetBrains Mono, Young
  Serif, Schibsted Grotesk, or Spline Sans Mono — those belong to other themes in this repo and must
  not be shared.

Type scale: `.t-hero` clamp(2.4rem→4.6rem), `.t-1` clamp(1.9rem→3rem), `.t-2` clamp(1.3rem→1.8rem),
body 16px / 1.6.

### 4.4 Layout & motion rules
- Grounded, grid-driven layouts — this is an industrial/trade brand, not editorial fashion. Radii
  **2 / 6 / 12px** (deliberately tighter than the softer consumer themes — reads as engineered, not
  soft). Max container **1280px**, gutter clamp(20px→48px).
- Motion budget: subtle scroll-reveals (`opacity` + 16px translateY via IntersectionObserver), hover
  micro-interactions on part/category cards (image scale, CTA affordances). Nothing else. No
  Three.js, no canvas particles, no parallax. Respect `prefers-reduced-motion` globally.
- **Accessibility floor (WCAG 2.1 AA):** skip link, visible `:focus-visible` outlines, aria-labels
  on icon buttons, semantic headings, no horizontal scroll at 360px.

---

## 5. TECHNICAL SPEC

### 5.1 File structure
```
parts-mall-theme/
├── style.css                 # header + full design system (tokens, base, components)
├── functions.php             # setup, enqueue, part helpers, taxonomies, AJAX, disable cart
├── inc/seo.php               # persona docs, meta, OG, JSON-LD, partsmall_faq_items()
├── header.php / footer.php
├── front-page.php / index.php / page.php / 404.php
├── page-branches.php / page-agent.php / page-about.php / page-contact.php
├── archive-product.php / single-product.php
├── woocommerce/content-product.php   # part card
├── css/woocommerce.css       # WC-only styles, enqueued conditionally
├── js/main.js                # header scroll, reveals, mobile menu, filter drawer, enquiry modal, toast
├── js/catalogue-search.js    # homepage + header catalogue search-as-you-type
├── images/                   # generated hero/brand, category icons, part placeholders, textures
├── dummy-products.php        # WP-CLI importer: wp eval-file dummy-products.php (~30 parts)
├── dummy-branches.php        # WP-CLI importer: ~40 branches (idempotent, keyed on branch slug)
└── screenshot.png            # 1200×900 preview matching the real design
```

### 5.2 functions.php requirements
- **Theme supports:** title-tag, post-thumbnails, custom-logo, HTML5, woocommerce + gallery. Menus:
  **primary, footer**. Image size **`partsmall-card`** (e.g. 640×480 crop).
- **Enqueue:** Google Fonts (Space Grotesk 600/700; Public Sans 400–600; IBM Plex Mono), `style.css`,
  `css/woocommerce.css` (only `if (class_exists('WooCommerce'))`), and JS files (`js/main.js`,
  `js/catalogue-search.js`); `wp_localize_script` → **`partsmallData = {ajaxUrl, nonce}`**.

#### 5.2.1 Part attribute schema — LOCKED
Every `_part_*` meta MUST be registered with `register_post_meta('product', $key,
['show_in_rest'=>true, 'single'=>true, 'type'=>..., 'auth_callback'=>...])` so the catalogue is
readable via the standard WP/WooCommerce REST API for future CMS/integration use.

- **Identity:** `_part_number` (internal SKU-style code), `_part_oem_reference` (optional
  cross-reference number), `_part_category_group` (parent grouping, e.g. "Braking").
- **Compatibility:** `_part_compatible_makes` (comma list: Kia, Hyundai, Chevrolet, Ssangyong,
  Suzuki, Daewoo, GWM/Haval, Ford, Daihatsu, Nissan, Toyota), `_part_compatible_models` (free text).
- **Brand & quality:** `_part_private_brand` (Parts-Mall/PMC, NT, Car-Dex, Pomax, MX, Ex-Trim,
  Vichura, Pro-Tec, Dashi, or "OEM/Genuine"), `_part_warranty` (short warranty text — all private
  brands are Parts-Mall Corporation warranted).
- **Availability:** `_part_availability` (in_stock | order_in | check_branch).

#### 5.2.2 Taxonomies — LOCKED
- `product_cat` = **part category**, two-level (parent → child) consolidated from the legacy
  ~250-value flat list into sane parent groups: Braking, Engine, Electrical & Sensors, Suspension &
  Steering, Filters, Transmission & Clutch, Cooling System, Fuel System, Body & Trim, Bearings,
  Gaskets & Seals, Belts & Chains, Accessories. Each parent has representative child categories
  (e.g. Braking → Brake Pads, Brake Shoes, Callipers, Discs & Rotors, Boosters).
- Custom public taxonomy (with admin column): **`part_make`** (vehicle make compatibility, so the
  catalogue can be filtered/browsed by make natively).
- Custom public taxonomy: **`part_brand`** (the private/house brand — Parts-Mall/PMC, NT, Car-Dex,
  Pomax, MX, Ex-Trim, Vichura, Pro-Tec, Dashi, OEM/Genuine).

#### 5.2.3 PHP helper signatures (single source of truth) — LOCKED
- `partsmall_category_groups(): array` — parent slug => ['label','icon','children'=>[...]].
- `partsmall_makes(): array` — make slug => label.
- `partsmall_private_brands(): array` — brand slug => ['label','logo'].
- `partsmall_meta(int $id, string $key): mixed`
- `partsmall_branches(): array` — grouped by province, each branch: name, address, phone, email
  (optional), country (for pan-African entries). Sourced from real scraped branch data (§ see repo
  research); used by both the branch locator page and Organization/LocalBusiness structured data.
- `partsmall_faq_items(): array` — feeds the FAQ content on the About/Contact pages + FAQPage
  schema. Lives in `inc/seo.php`.
- `partsmall_part_badges(WC_Product $p): array` — ['label','tone'] (Private Brand/OEM/Featured).

#### 5.2.4 Disabled WooCommerce commerce — LOCKED
- Remove add-to-cart buttons everywhere.
- Cart & checkout pages short-circuit (force-empty / redirect their endpoints).
- Remove sale flash and price-suffix commerce chrome not relevant to a quote/enquiry model (prices
  may still display where the business wants an indicative price, but never a "buy now" flow).
- `add_filter('woocommerce_show_page_title','__return_false')`.
- Products per page **16**.
- Breadcrumb delimiter **›**.

#### 5.2.5 AJAX — LOCKED
Register handler nonce-checked (nonce **`partsmall_nonce`**, localized object **`partsmallData`**):
- **`partsmall_enquiry`** → returns `{ok:bool, message:string}`. Used by the part enquiry modal,
  Become an Agent form, and Contact form (with a `type` field distinguishing the three).
- **`partsmall_catalogue_search`** → returns `{count:int, ids:int[], cards_html:string}` for the
  header/homepage search-as-you-type.

`require` `inc/seo.php` from `functions.php`.

**Forbidden:** any custom `do_action` hooks; any AI / integration plugin name or AI references in
code or comments.

### 5.3 SEO spec (inc/seo.php)
- **`wp_head` priority 1:** persona-switched meta description + keywords + OG/twitter per context
  (front → Persona 1/3; part → category/make-aware; category archive → Persona 1; Become an Agent →
  Persona 2/4; About → Persona 4). OG title/type/url/description/image + twitter
  `summary_large_image`.
- **`wp_head` priority 2 JSON-LD:**
  - **Organization** with `AutoPartsStore`-style additionalType, areaServed ZA + neighbouring
    countries, and `department`/`location` entries built from `partsmall_branches()`.
  - **WebSite + SearchAction** targeting `?s={search_term_string}&post_type=product`.
  - **Product** (name, category, brand, sku from `_part_number`, itemCondition; Offer only when a
    price is set, availability from `_part_availability`).
  - **BreadcrumbList** on parts + category archives.
  - **FAQPage** built from `partsmall_faq_items()`.

### 5.4 Dummy data
~30 parts spanning the consolidated category groups (§5.2.2), each with a written part number,
private brand assignment, compatible makes, warranty text, and availability status. Insert
**idempotently keyed on `_part_number`**; assign `product_cat` (parent + child) + `part_make` +
`part_brand` taxonomies; attach a placeholder image from `images/`. Also seed ~40 branches (real
names/provinces from the researched branch list) via `dummy-branches.php`, idempotent on branch
slug, feeding `partsmall_branches()`.

### 5.5 Generated imagery
Hero imagery (industrial-trade warehouse/counter feel — confident, not clichéd), a category-icon
system for the twelve parent groups, brand-neutral placeholder part imagery for the dummy catalogue
(no real OEM/manufacturer logos), favicon and logo lockup. Keep prompts on-brand: navy (#0F2F73) +
emerald (#0F9D58), clean, precise, trade-confident — not a stock auto-parts photo cliché.

### 5.6 Quality bar / acceptance criteria
- [ ] Activating with WooCommerce + imported dummy data (parts + branches) produces a complete,
      navigable catalogue and branch locator, zero placeholder text, **no cart/checkout reachable
      anywhere**.
- [ ] Catalogue filters (category, make, private brand, availability), sort and pagination all work;
      mobile (≤900px) uses drawer filters, overlay menu, no horizontal scroll at 360px.
- [ ] Catalogue search-as-you-type returns correct, live results.
- [ ] Branch locator groups correctly by province with pan-African branches shown separately.
- [ ] Keyboard-only navigation works end to end.
- [ ] Rich Results valid for Product, BreadcrumbList, FAQPage, WebSite, Organization.
- [ ] Nothing reads as templated; copy is specific and human; SA/pan-African context is real.
- [ ] No custom `do_action` hooks; no AI branding in code.

### 5.7 Installation (document in output)
1. Zip the `parts-mall-theme/` folder → WP Admin → Appearance → Themes → Upload → Activate.
2. Ensure WooCommerce is active. Run `wp eval-file wp-content/themes/parts-mall-theme/dummy-products.php`
   then `wp eval-file wp-content/themes/parts-mall-theme/dummy-branches.php`.
3. Settings → Reading → set a static front page ("Home").
4. Create pages Find a Branch, Become an Agent, About, Contact and assign their templates.
5. Optionally upload the bundled `images/` assets to Media.

---

## 6. VOICE & COPY RULES

Write all interface copy from the trade buyer's side of the screen. Specific beats clever; clever
beats generic. Active voice, sentence case, plain verbs. Buttons say what happens — **"Enquire
about this part", "Find a branch", "Become an agent"** — never "Submit" or "Buy now". Errors and
empty states give direction, not apology. The brand voice is confident, industrial, trustworthy — a
supplier that has been doing this at scale for years and knows its network cold. South African and
pan-African context is real, not decorative: real province names, real branch counts, real private
brand names — never invented statistics.
