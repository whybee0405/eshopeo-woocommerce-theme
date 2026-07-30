# KMS Branch

A WordPress theme for the two Korean Motor Spares branches in the south of
Gauteng: **Lenasia** and **Vereeniging**. Built as a Google Ads destination,
so it is three pages and no more.

| URL | Template | Use it for |
| --- | --- | --- |
| `/` | `front-page.php` | Brand or generic campaigns. Routes to whichever branch is closer. |
| `/lenasia/` | `page-lenasia.php` | Final URL for Lenasia ad groups. |
| `/vereeniging/` | `page-vereeniging.php` | Final URL for Vereeniging ad groups. |

The primary conversion action throughout is **WhatsApp**, with click-to-call
as the secondary. Both open with a pre-filled message that prompts for
vehicle, year and part, so the first reply from the customer already contains
what the counter needs to answer.

---

## Installing

1. Zip the theme (see *Packaging* below) and upload it under
   **Appearance → Themes → Add New → Upload Theme**, then activate.
2. Create three pages:
   - one set as the static front page under **Settings → Reading**
   - one with the slug **`lenasia`**
   - one with the slug **`vereeniging`**

   The slug is what binds a page to its branch template. Leave the page
   content empty; the templates render everything. If you would rather nest
   the pages, assign the template by hand from **Page Attributes → Template**
   instead, and internal links will still resolve.
3. Set permalinks to **Post name** under **Settings → Permalinks**.

Nothing else is required. There is no plugin dependency and no API key.

---

## Editing branch details

**Appearance → Customize → Branch details** covers phone number, WhatsApp
number and trading hours per branch, per day. Leave a field blank to keep the
built-in default.

Hours take the form `08:00-17:00`, or the word `Closed`. Anything else is
rejected and the default is used.

Everything else about a branch (address, the areas it serves, the
introductory line) lives in `inc/branches.php`. That file is the single
source of truth: the page copy, the footer, the JSON-LD and the map embed all
read from it, so a change there propagates everywhere at once.

### Trading hours need confirming

The hours currently in `inc/branches.php` are **Mon–Fri 08:00–17:00,
Sat 08:00–13:00, Sun closed**. Vereeniging's Monday to Wednesday hours match
what is published online; the rest is the standard pattern for the trade and
has not been confirmed with either branch. Please check both and correct them
in the Customizer before the campaigns go live, because the same hours drive
the "Open now" pill, the hours table and the structured data Google reads.

---

## What is on the page and why

**Live open/closed status.** Rendered server-side so it is right without
JavaScript, then recomputed on the client. That second pass matters: behind a
full-page cache the HTML would otherwise be frozen at whatever the state was
when the page was generated, and a stale "Open now" costs a wasted trip. The
client calculation uses the shop's timezone, not the visitor's.

**Structured data.** Each branch emits `AutoPartsStore` JSON-LD with address,
phone, hours and areas served. This is what feeds the local treatment in
Google's results and keeps the landing page consistent with the Business
Profile the ads point at.

**Sticky action bar on mobile.** WhatsApp and call, with
`env(safe-area-inset-bottom)` respected. On the landing page it is a single
button to the branch list instead, because a WhatsApp button with no branch
attached would be a lie. It stays down while the hero's own WhatsApp button is
still on screen.

**Map links are addressed by CID, never by name.** Several unrelated
businesses in both Lenasia and Vereeniging trade as "Korean Motor Spares" -
Vereeniging has a second one a few streets away at 3 Voortrekker St with its
own website. A `?query=Korean+Motor+Spares,+28+De+Villiers+Ave` link lets
Google pick between them, which is how a customer ends up at a competitor.
Every map link now uses the branch's Google CID, and "Get directions" routes
to its exact coordinates. Neither can resolve to another business.

**No hamburger.** There are two destinations. A two-up tab bar under the
header is faster, always visible, and needs no JavaScript.

---

## Design notes

The visual language is **quiet, modern and photography-led**. Blue is the
brand colour and carries the interface; yellow is an accent that marks things,
never a surface. Hairline rules, generous whitespace, soft corners, sentence
case. Nothing shouts.

An earlier revision took the shopfront signage literally: flat chrome-yellow
surfaces, condensed all-caps display type, a diagonal hazard stripe. It read
as a clearance sale rather than a thirty-year supplier, so it was replaced
outright rather than toned down.

**Colour.** KMS blue `#1868B8` sampled out of the logo file, signage yellow
`#F3EA18` sampled off a shopfront photograph. Declared in OKLCH. Every
neutral is tinted toward the brand blue; there is no pure black or white
anywhere. The yellow now appears at roughly one percent of the surface: the
small rule on each section label, and the active navigation underline.

**Type.** Instrument Sans, one variable file covering weights 400 to 700,
self-hosted at about 30 KB. All hierarchy comes from scale and weight rather
than a second typeface. No third-party font request and nothing to disclose
in a cookie notice.

**Hero.** The frame was generated with its subject in the right third and the
left two thirds left as empty concrete, so on desktop the headline sits
inside the picture rather than on a band above it. Below 64em it stacks:
picture, then words. A left-to-right wash guarantees the contrast floor
without reading as a scrim, and a separate phone crop pulls in on the parts
so they still register at 360px.

**Motion.** Exponential ease-out curves, nothing over 300 ms, nothing that
bounces. Buttons take `scale(0.98)` on press. Hover states are gated behind
`(hover: hover) and (pointer: fine)` so a tap on a phone does not trigger
them. Section reveals are staggered 45 ms apart and capped at five steps.

The sticky mobile bar stays down while the hero's own WhatsApp button is
still on screen, so the same green button never appears twice at the top of
the page. Note that the bar carries a solid background rather than a blur:
a `backdrop-filter` on a fixed element that also transforms wedges the
transform in Chrome, and a full-width blur repainting on every scroll frame
is a real cost on the mid-range Android this audience browses on.

Two behaviours are deliberately fail-safe. The scroll reveal keeps content
visible by default and only applies the hidden state once the script has
confirmed it can un-hide again, with a three-second timer that reveals
everything regardless. The sticky bar is likewise visible by default and only
opts into hiding under script control. Both fail in the safe direction.

**Scroll reveals.** Sections, cards, grid tiles and photographs fade up 12px
as they come into view, staggered 45 ms apart and capped at five steps.
Photographs settle from `scale(1.015)`, small enough to read as the image
arriving rather than as an effect. Only opacity and transform move, so
nothing can shift layout mid-scroll, and `will-change` is released once each
element has landed rather than left on for the life of the page.

The reveal failsafe is cancelled by the observer's first callback rather than
left on a timer. IntersectionObserver reports on every observed element
immediately, so one callback proves it works; a blanket timer would instead
reveal the whole page out from under anyone who reads the hero for a few
seconds before scrolling.

**Verified in-browser**, not asserted. Contrast, touch targets, heading order,
single-h1, alt attributes and horizontal overflow were measured across three
pages at 360, 390, 768, 1024 and 1440: **15 combinations, 1341 text elements
in total, zero failures**. Colours are resolved through a canvas rather
than string-parsed, because `getComputedStyle` returns OKLCH literals here and
naive parsing silently reports nonsense. Hero text is measured separately
against the composited photograph pixels rather than a flat background:
headline 13.4:1, body copy 5.8:1, label 6.2:1.

---

## Imagery

`assets/img/source/` holds the originals and is not shipped.
`assets/img/build-images.py` crops and encodes them to WebP at two widths
each. Re-run it after changing any source file:

```bash
cd assets/img && python build-images.py
```

**Real photography** carries the trust load: the shopfront and street shots
are genuine Korean Motor Spares branches, and the seven part-category tiles
are the group's own product photography.

**Generated photography** fills the gaps only where no real photo exists: the
hero flat-lay, the alternator shot and the parts-in-hand shot. These are
generic working scenes with no signage, no branding and no readable text in
them, so nothing is being passed off as something it is not.

### One thing to fix before launch

There is **no photograph of the Lenasia or Vereeniging shopfront**. Both
branch pages currently show a different Korean Motor Spares branch, captioned
*"Look for the yellow board. Every Korean Motor Spares counter carries it."*
That caption is true and the image is useful for spotting the shop, but a
photo of the actual branch would be better on every count. Two phone photos
of each shopfront in portrait would do it:

1. drop them in `assets/img/source/` as `lenasia-shopfront.jpg` and
   `vereeniging-shopfront.jpg`
2. add them to `JOBS` in `build-images.py` at aspect `3/4`
3. swap the image and drop the caption in
   `template-parts/branch-page.php`

---

## Packaging

```bash
bash build/package.sh
```

Writes `dist/kms-branch-theme.zip`, excluding `_preview/`, `build/`,
`assets/img/source/`, `README.md` and any dotfiles. That zip is what goes
into **Appearance → Themes → Upload Theme**.

---

## Previewing without WordPress

```bash
php _preview/render.php
php -S 127.0.0.1:8787 -t .
# then open http://127.0.0.1:8787/_preview/index.html
```

`_preview/render.php` stubs the handful of WordPress functions the templates
touch and writes the three pages to flat HTML. It is a development tool, it
is excluded from the package, and deleting it breaks nothing.

---

## File map

```
inc/branches.php        Branch records, open/closed logic, WhatsApp and map URLs
inc/schema.php          AutoPartsStore JSON-LD
inc/customizer.php      Phone, WhatsApp and per-day hours controls
inc/icons.php           Inline SVG set, one family, 24px grid

front-page.php          Landing page
page-lenasia.php        Sets the branch, loads the shared branch body
page-vereeniging.php    Same, for Vereeniging
template-parts/
  branch-page.php       The whole branch page. Both branches render this one file.
  branch-card.php       Branch card used by the landing page router
  parts-grid.php        Part categories
  status.php            Open/closed pill

assets/css/main.css     Everything. Tokens at the top, sections numbered.
assets/js/main.js       Status recompute, staggered reveal. No dependencies.
```

Both branch pages render `template-parts/branch-page.php` with a different
record. That is what stops Lenasia and Vereeniging drifting apart as the site
gets edited over time.
