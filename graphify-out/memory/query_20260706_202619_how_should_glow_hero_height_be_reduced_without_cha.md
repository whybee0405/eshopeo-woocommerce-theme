---
type: "implementation"
date: "2026-07-06T20:26:19.685971+00:00"
question: "How should Glow hero height be reduced without changing the animated product slider size?"
contributor: "graphify"
outcome: "corrected"
---

# Q: How should Glow hero height be reduced without changing the animated product slider size?

## Answer

Do not resize the animated .hero-stage slider when shortening the homepage hero. Keep its original desktop aspect ratio 4 / 4.6, tablet 4 / 3.4, and mobile 4 / 5. Reduce the hero footprint through hero padding and a hero-only H1 override instead; current H1 size is .hero .t-hero font-size clamp(2rem, 4vw, 3.85rem), with hero padding clamp(24px, 3.6vw, 52px).

## Outcome

- Signal: corrected