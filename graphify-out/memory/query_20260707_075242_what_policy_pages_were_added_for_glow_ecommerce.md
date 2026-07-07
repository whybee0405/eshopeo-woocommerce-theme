---
type: "implementation"
date: "2026-07-07T07:52:42.452383+00:00"
question: "What policy pages were added for Glow ecommerce?"
contributor: "graphify"
outcome: "useful"
---

# Q: What policy pages were added for Glow ecommerce?

## Answer

Added theme-managed WordPress slug templates: page-privacy-policy.php at /privacy-policy, page-refunds-policy.php at /refunds-policy, and page-terms-of-service.php at /terms-of-service. Footer now includes a Policies column linking to all three. functions.php uses glow_ensure_theme_pages on after_switch_theme and admin_init to create brand-kit plus policy pages. inc/seo.php includes dedicated meta descriptions. Tests cover templates, footer links, ensured slugs and SEO branches.

## Outcome

- Signal: useful