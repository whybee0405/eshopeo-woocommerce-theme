# Graph Report - cosmetics-woocommerce-theme  (2026-07-06)

## Corpus Check
- 145 files · ~1,318,033 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 695 nodes · 772 edges · 143 communities (123 shown, 20 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 39 edges (avg confidence: 0.76)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `2982754d`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- [[_COMMUNITY_functions.php|functions.php]]
- [[_COMMUNITY_functions.php|functions.php]]
- [[_COMMUNITY_5. TECHNICAL SPEC|5. TECHNICAL SPEC]]
- [[_COMMUNITY_main.js|main.js]]
- [[_COMMUNITY_What You Must Do When Invoked|What You Must Do When Invoked]]
- [[_COMMUNITY_What You Must Do When Invoked|What You Must Do When Invoked]]
- [[_COMMUNITY_2. DESIGN SYSTEM (non-negotiable)|2. DESIGN SYSTEM (non-negotiable)]]
- [[_COMMUNITY_seo.php|seo.php]]
- [[_COMMUNITY_functions.php|functions.php]]
- [[_COMMUNITY_main.js|main.js]]
- [[_COMMUNITY_hero-room.js|hero-room.js]]
- [[_COMMUNITY_concierge.js|concierge.js]]
- [[_COMMUNITY_graphify reference extra exports and benchmark|graphify reference: extra exports and benchmark]]
- [[_COMMUNITY_graphify reference extra exports and benchmark|graphify reference: extra exports and benchmark]]
- [[_COMMUNITY_affordability.js|affordability.js]]
- [[_COMMUNITY_Product|Product]]
- [[_COMMUNITY_main.js|main.js]]
- [[_COMMUNITY_Digicars — WooCommerce theme|Digicars — WooCommerce theme]]
- [[_COMMUNITY_cove_run_import|cove_run_import]]
- [[_COMMUNITY_filters.js|filters.js]]
- [[_COMMUNITY_elementor-widgets.php|elementor-widgets.php]]
- [[_COMMUNITY_Glow_Best_Sellers_Widget|Glow_Best_Sellers_Widget]]
- [[_COMMUNITY_Glow_Ingredient_Index_Widget|Glow_Ingredient_Index_Widget]]
- [[_COMMUNITY_Glow_Newsletter_Widget|Glow_Newsletter_Widget]]
- [[_COMMUNITY_Glow_Review_Cards_Widget|Glow_Review_Cards_Widget]]
- [[_COMMUNITY_Glow_Sourcing_Split_Widget|Glow_Sourcing_Split_Widget]]
- [[_COMMUNITY_graphify reference query, path, explain|graphify reference: query, path, explain]]
- [[_COMMUNITY_graphify reference query, path, explain|graphify reference: query, path, explain]]
- [[_COMMUNITY_hero-canvas.js|hero-canvas.js]]
- [[_COMMUNITY_Glow_Concern_Tiles_Widget|Glow_Concern_Tiles_Widget]]
- [[_COMMUNITY_Glow_Routine_Rail_Widget|Glow_Routine_Rail_Widget]]
- [[_COMMUNITY_Glow K-Beauty — WooCommerce Theme|Glow K-Beauty — WooCommerce Theme]]
- [[_COMMUNITY_dummy-products.php|dummy-products.php]]
- [[_COMMUNITY_particles.js|particles.js]]
- [[_COMMUNITY_graphify reference add a URL and watch a folder|graphify reference: add a URL and watch a folder]]
- [[_COMMUNITY_graphify reference commit hook and native CLAUDE.md integration|graphify reference: commit hook and native CLAUDE.md integration]]
- [[_COMMUNITY_graphify reference incremental update and cluster-only|graphify reference: incremental update and cluster-only]]
- [[_COMMUNITY_graphify reference add a URL and watch a folder|graphify reference: add a URL and watch a folder]]
- [[_COMMUNITY_graphify reference commit hook and native CLAUDE.md integration|graphify reference: commit hook and native CLAUDE.md integration]]
- [[_COMMUNITY_graphify reference incremental update and cluster-only|graphify reference: incremental update and cluster-only]]
- [[_COMMUNITY_graphify reference GitHub clone and cross-repo merge|graphify reference: GitHub clone and cross-repo merge]]
- [[_COMMUNITY_graphify reference transcribe video and audio|graphify reference: transcribe video and audio]]
- [[_COMMUNITY_graphify reference GitHub clone and cross-repo merge|graphify reference: GitHub clone and cross-repo merge]]
- [[_COMMUNITY_graphify reference transcribe video and audio|graphify reference: transcribe video and audio]]
- [[_COMMUNITY_admin-import.php|admin-import.php]]
- [[_COMMUNITY_AGENTS|AGENTS.md]]
- [[_COMMUNITY_CLAUDE|CLAUDE.md]]
- [[_COMMUNITY_CLAUDE|CLAUDE.md]]
- [[_COMMUNITY_extraction-spec|extraction-spec.md]]
- [[_COMMUNITY_extraction-spec|extraction-spec.md]]
- [[_COMMUNITY_functions.php|functions.php]]
- [[_COMMUNITY_main.js|main.js]]
- [[_COMMUNITY_kbap_run_import|kbap_run_import]]
- [[_COMMUNITY_K-BAP WooCommerce Theme|K-BAP WooCommerce Theme]]
- [[_COMMUNITY_Q How is Graphify configured as shared memory for this WooCommerce theme repo|Q: How is Graphify configured as shared memory for this WooCommerce theme repo?]]
- [[_COMMUNITY_Q Is Obra Superpowers installed for this machine and repo workflow|Q: Is Obra Superpowers installed for this machine and repo workflow?]]
- [[_COMMUNITY_Q What was added for the K-BAP WooCommerce theme|Q: What was added for the K-BAP WooCommerce theme?]]
- [[_COMMUNITY_Q What was the first approved K-BAP refactor increment|Q: What was the first approved K-BAP refactor increment?]]
- [[_COMMUNITY_Q What K-BAP refactor implementation was completed with the multi-agent method|Q: What K-BAP refactor implementation was completed with the multi-agent method?]]
- [[_COMMUNITY_Q What did the Playwright visual review find for the K-BAP homepage and what changed|Q: What did the Playwright visual review find for the K-BAP homepage and what changed?]]
- [[_COMMUNITY_Q How was the K-BAP interactive homepage hero implemented|Q: How was the K-BAP interactive homepage hero implemented?]]

## God Nodes (most connected - your core abstractions)
1. `glow_wc_active()` - 20 edges
2. `What You Must Do When Invoked` - 12 edges
3. `What You Must Do When Invoked` - 12 edges
4. `/graphify` - 11 edges
5. `digicars_seo_build_meta()` - 11 edges
6. `/graphify` - 10 edges
7. `digicars_json_ld()` - 10 edges
8. `$all()` - 10 edges
9. `init()` - 10 edges
10. `5. TECHNICAL SPEC` - 9 edges

## Surprising Connections (you probably didn't know these)
- `glow_setup_page()` --calls--> `glow_wc_active()`  [INFERRED]
  glow-theme/inc/admin-setup.php → glow-theme/functions.php
- `kbap_meta_tags()` --calls--> `kbap_wc_active()`  [INFERRED]
  kbap-theme/inc/seo.php → kbap-theme/functions.php
- `kbap_og_image()` --calls--> `kbap_wc_active()`  [INFERRED]
  kbap-theme/inc/seo.php → kbap-theme/functions.php
- `kbap_schema_product()` --calls--> `kbap_wc_active()`  [INFERRED]
  kbap-theme/inc/seo.php → kbap-theme/functions.php
- `kbap_seo_description()` --calls--> `kbap_wc_active()`  [INFERRED]
  kbap-theme/inc/seo.php → kbap-theme/functions.php

## Import Cycles
- None detected.

## Communities (143 total, 20 thin omitted)

### Community 0 - "functions.php"
Cohesion: 0.08
Nodes (23): glow_enqueue(), glow_footer_columns(), glow_meta(), glow_primary_menu_fallback(), glow_product_badges(), glow_product_image(), glow_quick_add(), glow_routine_rail() (+15 more)

### Community 1 - "functions.php"
Cohesion: 0.08
Nodes (18): checked(), digicars_filter_val(), digicars_render_filters(), digicars_shop_base_url(), sanitize_html_class(), selected(), digicars_ajax_concierge_match(), digicars_apply_catalogue_filters() (+10 more)

### Community 2 - "5. TECHNICAL SPEC"
Cohesion: 0.06
Nodes (31): 1. PROJECT BRIEF, 2.1 Concept, 2.2 The signature element: The Concierge, 2.3 Palette — elevated orange + charcoal (NOT generic corporate orange), 2.4 Typography (Google Fonts), 2.5 Layout & motion rules, 2. DESIGN SYSTEM (non-negotiable), 3. THE FIVE PERSONAS (drive SEO + page content) (+23 more)

### Community 3 - "main.js"
Cohesion: 0.11
Nodes (17): activateStep(), advance(), getWishlist(), goNext(), goPrev(), navigate(), openMenu(), openSearch() (+9 more)

### Community 4 - "What You Must Do When Invoked"
Cohesion: 0.07
Nodes (26): For /graphify add and --watch, For /graphify query, For the commit hook and native CLAUDE.md integration, For --update and --cluster-only, /graphify, Honesty Rules, Interpreter guard for subcommands, Part A - Structural extraction for code files (+18 more)

### Community 5 - "What You Must Do When Invoked"
Cohesion: 0.08
Nodes (24): For /graphify add and --watch, For /graphify query, For the commit hook and native CLAUDE.md integration, For --update and --cluster-only, /graphify, Honesty Rules, Interpreter guard for subcommands, Part A - Structural extraction for code files (+16 more)

### Community 6 - "2. DESIGN SYSTEM (non-negotiable)"
Cohesion: 0.08
Nodes (24): 1. PROJECT BRIEF, 2.1 Concept, 2.2 The signature element: The Routine Rail, 2.3 Palette — drawn from Korean skincare ingredients (rice water, mugwort, yuja citron, seafoam algae, clay). NOT the pink/mint K-beauty cliché., 2.4 Typography (Google Fonts), 2.5 Cultural grounding, 2.6 Layout & motion rules, 2. DESIGN SYSTEM (non-negotiable) (+16 more)

### Community 7 - "seo.php"
Cohesion: 0.21
Nodes (23): digicars_build_ai_summary(), digicars_meta(), digicars_monthly_from(), digicars_faq_items(), digicars_json_ld(), digicars_meta_tags(), digicars_seo_blogposting_schema(), digicars_seo_breadcrumb() (+15 more)

### Community 8 - "functions.php"
Cohesion: 0.09
Nodes (6): cove_apply_catalogue_filters(), cove_meta(), cove_meta_definitions(), cove_register_meta(), cove_saving(), WP_Query

### Community 9 - "main.js"
Cohesion: 0.23
Nodes (20): $(), $all(), buildEnquiryModal(), digicarsToast(), ensureToastRegion(), init(), initCardTilt(), initCompare() (+12 more)

### Community 10 - "hero-room.js"
Cohesion: 0.27
Nodes (5): addShadow(), animate(), hideTooltip(), makeCoffeeMachine(), showTooltip()

### Community 11 - "concierge.js"
Cohesion: 0.42
Nodes (7): $(), $all(), init(), initConcierge(), initInline(), initLaunchers(), trapFocus()

### Community 12 - "graphify reference: extra exports and benchmark"
Cohesion: 0.22
Nodes (8): graphify reference: extra exports and benchmark, Step 6b - Wiki (only if --wiki flag), Step 7 - Neo4j export (only if --neo4j or --neo4j-push flag), Step 7a - FalkorDB export (only if --falkordb or --falkordb-push flag), Step 7b - SVG export (only if --svg flag), Step 7c - GraphML export (only if --graphml flag), Step 7d - MCP server (only if --mcp flag), Step 8 - Token reduction benchmark (only if total_words > 5000)

### Community 13 - "graphify reference: extra exports and benchmark"
Cohesion: 0.22
Nodes (8): graphify reference: extra exports and benchmark, Step 6b - Wiki (only if --wiki flag), Step 7 - Neo4j export (only if --neo4j or --neo4j-push flag), Step 7a - FalkorDB export (only if --falkordb or --falkordb-push flag), Step 7b - SVG export (only if --svg flag), Step 7c - GraphML export (only if --graphml flag), Step 7d - MCP server (only if --mcp flag), Step 8 - Token reduction benchmark (only if total_words > 5000)

### Community 14 - "affordability.js"
Cohesion: 0.33
Nodes (5): $(), $all(), init(), initContainer(), parseIntSafe()

### Community 15 - "Product"
Cohesion: 0.22
Nodes (8): Accessibility & Inclusion, Anti-references, Brand Personality, Design Principles, Product, Product Purpose, Register, Users

### Community 17 - "Digicars — WooCommerce theme"
Cohesion: 0.25
Nodes (7): Design system, Development notes, Digicars — WooCommerce theme, Installation, Integration seam (for a future AI layer), Replacing the placeholder imagery, What's included

### Community 18 - "cove_run_import"
Cohesion: 0.33
Nodes (4): cove_dummy_products(), cove_admin_import_page(), cove_run_import(), WP_Error

### Community 19 - "filters.js"
Cohesion: 0.38
Nodes (3): closeDrawer(), createOverlay(), openDrawer()

### Community 26 - "graphify reference: query, path, explain"
Cohesion: 0.33
Nodes (5): For /graphify explain, For /graphify path, graphify reference: query, path, explain, Step 0 — Constrained query expansion (REQUIRED before traversal), Step 1 — Traversal

### Community 27 - "graphify reference: query, path, explain"
Cohesion: 0.33
Nodes (5): For /graphify explain, For /graphify path, graphify reference: query, path, explain, Step 0 — Constrained query expansion (REQUIRED before traversal), Step 1 — Traversal

### Community 28 - "hero-canvas.js"
Cohesion: 0.60
Nodes (5): buildNodes(), draw(), init(), makeNode(), resize()

### Community 31 - "Glow K-Beauty — WooCommerce Theme"
Cohesion: 0.33
Nodes (5): Design system, in brief, Glow K-Beauty — WooCommerce Theme, Installation, SEO, What's inside

### Community 33 - "particles.js"
Cohesion: 0.60
Nodes (3): draw(), initParticles(), rand()

### Community 34 - "graphify reference: add a URL and watch a folder"
Cohesion: 0.50
Nodes (3): For /graphify add, For --watch, graphify reference: add a URL and watch a folder

### Community 35 - "graphify reference: commit hook and native CLAUDE.md integration"
Cohesion: 0.50
Nodes (3): For git commit hook, For native CLAUDE.md integration, graphify reference: commit hook and native CLAUDE.md integration

### Community 36 - "graphify reference: incremental update and cluster-only"
Cohesion: 0.50
Nodes (3): For --cluster-only, For --update (incremental re-extraction), graphify reference: incremental update and cluster-only

### Community 37 - "graphify reference: add a URL and watch a folder"
Cohesion: 0.50
Nodes (3): For /graphify add, For --watch, graphify reference: add a URL and watch a folder

### Community 38 - "graphify reference: commit hook and native CLAUDE.md integration"
Cohesion: 0.50
Nodes (3): For git commit hook, For native CLAUDE.md integration, graphify reference: commit hook and native CLAUDE.md integration

### Community 39 - "graphify reference: incremental update and cluster-only"
Cohesion: 0.50
Nodes (3): For --cluster-only, For --update (incremental re-extraction), graphify reference: incremental update and cluster-only

### Community 117 - "functions.php"
Cohesion: 0.10
Nodes (20): kbap_enqueue(), kbap_faq_items(), kbap_hero_table_dishes(), kbap_menu_sections(), kbap_meta_definitions(), kbap_nav_items(), kbap_product_or_menu_url(), kbap_register_meta() (+12 more)

### Community 118 - "main.js"
Cohesion: 0.50
Nodes (8): initForms(), initHeader(), initMenu(), initMenuNav(), initReveal(), initTableHero(), qs(), qsa()

### Community 119 - "kbap_run_import"
Cohesion: 0.38
Nodes (4): kbap_dummy_products(), kbap_import_image(), kbap_run_import(), kbap_admin_import_page()

### Community 120 - "K-BAP WooCommerce Theme"
Cohesion: 0.33
Nodes (5): Design Notes, K-BAP WooCommerce Theme, Requirements, Setup, Theme Files

### Community 121 - "Q: How is Graphify configured as shared memory for this WooCommerce theme repo?"
Cohesion: 0.40
Nodes (4): Answer, Outcome, Q: How is Graphify configured as shared memory for this WooCommerce theme repo?, Source Nodes

### Community 122 - "Q: Is Obra Superpowers installed for this machine and repo workflow?"
Cohesion: 0.40
Nodes (4): Answer, Outcome, Q: Is Obra Superpowers installed for this machine and repo workflow?, Source Nodes

### Community 138 - "Q: What was added for the K-BAP WooCommerce theme?"
Cohesion: 0.40
Nodes (4): Answer, Outcome, Q: What was added for the K-BAP WooCommerce theme?, Source Nodes

### Community 139 - "Q: What was the first approved K-BAP refactor increment?"
Cohesion: 0.50
Nodes (3): Answer, Outcome, Q: What was the first approved K-BAP refactor increment?

### Community 140 - "Q: What K-BAP refactor implementation was completed with the multi-agent method?"
Cohesion: 0.50
Nodes (3): Answer, Outcome, Q: What K-BAP refactor implementation was completed with the multi-agent method?

### Community 141 - "Q: What did the Playwright visual review find for the K-BAP homepage and what changed?"
Cohesion: 0.50
Nodes (3): Answer, Outcome, Q: What did the Playwright visual review find for the K-BAP homepage and what changed?

### Community 142 - "Q: How was the K-BAP interactive homepage hero implemented?"
Cohesion: 0.50
Nodes (3): Answer, Outcome, Q: How was the K-BAP interactive homepage hero implemented?

## Knowledge Gaps
- **171 isolated node(s):** `graphify`, `Usage`, `What graphify is for`, `Step 0 - GitHub repos and multi-path merge (only if a URL or several paths)`, `Step 1 - Ensure graphify is installed` (+166 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **20 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Work-memory lessons

**Preferred sources** — corroborated by past sessions; start here.
- `AGENTS.md` (2× useful, score=1.994477069)

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `glow_wc_active()` connect `functions.php` to `Glow_Sourcing_Split_Widget`, `Glow_Best_Sellers_Widget`, `Glow_Ingredient_Index_Widget`?**
  _High betweenness centrality (0.008) - this node is a cross-community bridge._
- **Why does `Glow_Hero_Stage_Widget` connect `elementor-widgets.php` to `functions.php`, `Glow_Concern_Tiles_Widget`?**
  _High betweenness centrality (0.003) - this node is a cross-community bridge._
- **Why does `Glow_Ingredient_Index_Widget` connect `Glow_Ingredient_Index_Widget` to `elementor-widgets.php`, `Glow_Concern_Tiles_Widget`?**
  _High betweenness centrality (0.003) - this node is a cross-community bridge._
- **Are the 10 inferred relationships involving `glow_wc_active()` (e.g. with `glow_setup_page()` and `.render()`) actually correct?**
  _`glow_wc_active()` has 10 INFERRED edges - model-reasoned connections that need verification._
- **Are the 3 inferred relationships involving `digicars_seo_build_meta()` (e.g. with `digicars_build_ai_summary()` and `digicars_meta()`) actually correct?**
  _`digicars_seo_build_meta()` has 3 INFERRED edges - model-reasoned connections that need verification._
- **What connects `graphify`, `Usage`, `What graphify is for` to the rest of the system?**
  _171 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `functions.php` be split into smaller, more focused modules?**
  _Cohesion score 0.07575757575757576 - nodes in this community are weakly interconnected._