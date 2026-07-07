---
type: "bugfix"
date: "2026-07-06T18:19:03.926032+00:00"
question: "Why did /brand-kit 404 in glow-theme?"
contributor: "graphify"
outcome: "corrected"
---

# Q: Why did /brand-kit 404 in glow-theme?

## Answer

The brand kit template is page-brand-kit.php, but WordPress only loads page-{slug}.php after a published Page with slug brand-kit exists. The old code only created that page on after_switch_theme, so already-active installs could keep returning 404. Fixed by adding glow_ensure_brand_kit_page() and hooking it to both after_switch_theme and admin_init.

## Outcome

- Signal: corrected