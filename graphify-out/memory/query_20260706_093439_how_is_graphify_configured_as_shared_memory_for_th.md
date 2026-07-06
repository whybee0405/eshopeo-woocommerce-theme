---
type: "query"
date: "2026-07-06T09:34:39.822097+00:00"
question: "How is Graphify configured as shared memory for this WooCommerce theme repo?"
contributor: "graphify"
outcome: "useful"
source_nodes: ["AGENTS.md", "CLAUDE.md", "graphify-out/graph.json"]
---

# Q: How is Graphify configured as shared memory for this WooCommerce theme repo?

## Answer

Graphifyy 0.9.7 is installed. Project integrations exist for Codex (.codex/skills/graphify, .codex/hooks.json, AGENTS.md), Claude (.claude/skills/graphify, .claude/settings.json, CLAUDE.md), and shared agents (.agents/skills/graphify). Root AGENTS.md and CLAUDE.md require agents to query Graphify before broad project search, run graphify update . after code/prompt/theme/doc edits, and save durable lessons with graphify save-result. Git post-commit and post-checkout hooks are installed. graphify-out currently contains the code graph; full semantic doc/image extraction still needs an API key.

## Outcome

- Signal: useful

## Source Nodes

- AGENTS.md
- CLAUDE.md
- graphify-out/graph.json