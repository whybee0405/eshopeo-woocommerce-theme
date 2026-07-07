---
type: "implementation"
date: "2026-07-06T20:14:37.004545+00:00"
question: "What changed in the Glow hero correction after adding eShopeo search?"
contributor: "graphify"
outcome: "useful"
---

# Q: What changed in the Glow hero correction after adding eShopeo search?

## Answer

Eshopeo suggestion/buttons below the hero search bar should keep plugin/original styles, so avoid .hero-search button overrides. Homepage hero uses images/hero/hero-korean-beauty-faces.png, a wide people-plus-cosmetics background with left-side negative space. Hero height is reduced via clamp(36px, 5vw, 72px), tighter search/CTA/footnote spacing, and .hero-stage aspect-ratio 4 / 3.35.

## Outcome

- Signal: useful