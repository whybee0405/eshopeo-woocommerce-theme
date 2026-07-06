# K-BAP UX Specification

## Global UX Principles

- Food first, interface second.
- Simple navigation.
- Short copy.
- Clear actions.
- No decorative complexity.
- Mobile-first readability.
- Every page should answer what the visitor can do next.

## Shared Components

All pages should reuse:

- Site header.
- Footer.
- Page hero.
- Section header.
- Food image block.
- Dish card.
- Product card.
- Catering package card.
- Enquiry form.
- FAQ item.
- Trust statement.
- WooCommerce notice.
- Button styles.
- Form field styles.

## Homepage

Purpose: Introduce K-BAP as authentic Korean catering in South Africa and point visitors to menu, catering, and future products.

Hierarchy:

1. Hero with food photography and primary catering message.
2. Trust statement.
3. Signature dishes.
4. Catering formats.
5. Future product range.
6. Enquiry CTA.

Interactions:

- Primary CTA to catering.
- Secondary CTA to menu.
- Subtle reveal motion only.

Accessibility:

- H1 must describe the business.
- Hero image alt text should describe the food.

## About

Purpose: Explain K-BAP's trust, cultural credibility, and growth direction.

Hierarchy:

1. Brand story.
2. Trusted event context.
3. Food philosophy.
4. Future retail ambition.

## Menu

Purpose: Provide an SEO-friendly menu page that can replace a PDF as the main discoverable menu surface.

Hierarchy:

1. Menu intro.
2. Category navigation.
3. Dish sections.
4. Catering and quote note.
5. Enquiry CTA.

Requirements:

- All dishes must be HTML text.
- Each dish needs a name and short description.
- Use tags only when helpful.
- Prices can be "quote" where event-specific.

## Products

Purpose: Introduce online-ready products such as kimchi, meal kits, sauces, frozen products, and market drops.

Hierarchy:

1. Product range overview.
2. Featured products.
3. Product categories.
4. Store readiness note.
5. Shop CTA.

## Meal Kits

Purpose: Prepare a future category page for Korean home cooking kits.

Hierarchy:

1. Meal kit promise.
2. Featured kits: bulgogi, short rib stew, japchae.
3. What's included.
4. Storage and preparation notes.
5. Availability CTA.

## Kimchi

Purpose: Establish K-BAP Kimchi as a loved hero product.

Hierarchy:

1. Kimchi hero.
2. Taste profile.
3. Serving ideas.
4. Pack sizes.
5. Future stockist or order CTA.

## Catering

Purpose: Convert event organisers into enquiry leads.

Hierarchy:

1. Catering hero.
2. Package formats.
3. Signature catering dishes.
4. Process.
5. Enquiry form.
6. FAQ.

Interactions:

- Package selection can prefill enquiry topic later.
- Form should work without JavaScript where possible.

## Contact

Purpose: Make enquiries easy.

Hierarchy:

1. Short contact intro.
2. Enquiry form.
3. Contact details.
4. Response expectation.

## FAQ

Purpose: Reduce friction before enquiries.

Topics:

- Catering coverage.
- Guest counts.
- Dietary needs.
- Heat levels.
- Kimchi and future products.
- Event timing.
- Delivery and setup.

## Cart

Purpose: Support future WooCommerce orders without distracting from catering.

Requirements:

- Clear product summary.
- Quantity controls.
- Empty cart state that points to shop and catering.
- Mobile-friendly totals.

## Checkout

Purpose: Complete product orders with minimal friction.

Requirements:

- Clean form layout.
- Visible totals.
- Accessible errors.
- No unnecessary upsell clutter.

## Account

Purpose: Allow customers to manage future orders.

Requirements:

- Simple dashboard.
- Orders first.
- Addresses and account details secondary.

## 404

Purpose: Recover lost visitors.

Hierarchy:

1. Plain error message.
2. Menu link.
3. Catering link.
4. Shop link when products are active.

## Privacy

Purpose: Explain data use in plain language.

Requirements:

- Contact forms.
- WooCommerce orders.
- Cookies.
- Analytics.
- Email communication.

## Terms

Purpose: Set expectations for catering, orders, payments, delivery, cancellations, and product availability.

## Search

Purpose: Help users find dishes, products, and content.

Requirements:

- Search field prominent.
- Results grouped by product, page, and post where possible.
- Empty state suggests menu and catering.

## Blog

Purpose: Support SEO and education.

Content types:

- Dish guides.
- Kimchi serving ideas.
- Catering planning.
- Korean food in South Africa.
- Product launch updates.

## Responsive Behaviour

- Mobile nav must be keyboard accessible.
- Menu category navigation should not trap horizontal scroll.
- Cards collapse to one column on small screens.
- Forms should use one column on mobile.
- Product grids should avoid tiny cards.

