---
type: "query"
date: "2026-07-06T12:30:42.523528+00:00"
question: "How was the K-BAP interactive homepage hero implemented?"
contributor: "graphify"
outcome: "useful"
---

# Q: How was the K-BAP interactive homepage hero implemented?

## Answer

Implemented Concept 1 as an actual generated overhead dining-table image with semantic product/menu hotspots, not vectors. Committed as 4a0c65d feat(kbap): add interactive table hero. Key files: kbap-theme/front-page.php renders the table hero, kbap-theme/functions.php defines kbap_hero_table_dishes() and product/menu URL fallback logic, kbap-theme/style.css adds responsive table, hotspot, panel and dish rail styling, kbap-theme/js/main.js syncs hover/focus/touch state, and kbap-theme/images/interactive-table.jpg stores the compressed generated food table image. Visual QA was done with Playwright screenshots at desktop and mobile; PHP lint, JS syntax check and git diff whitespace check passed.

## Outcome

- Signal: useful