## graphify

This project has a knowledge graph at graphify-out/ with god nodes, community structure, and cross-file relationships.

When the user types `/graphify`, use the installed graphify skill or instructions before doing anything else.

Rules:
- For codebase questions, first run `graphify query "<question>"` when graphify-out/graph.json exists. Use `graphify path "<A>" "<B>"` for relationships and `graphify explain "<concept>"` for focused concepts. These return a scoped subgraph, usually much smaller than GRAPH_REPORT.md or raw grep output.
- Dirty graphify-out/ files are expected after hooks or incremental updates; dirty graph files are not a reason to skip graphify. Only skip graphify if the task is about stale or incorrect graph output, or the user explicitly says not to use it.
- If graphify-out/wiki/index.md exists, use it for broad navigation instead of raw source browsing.
- Read graphify-out/GRAPH_REPORT.md only for broad architecture review or when query/path/explain do not surface enough context.
- After modifying code, run `graphify update .` to keep the graph current (AST-only, no API cost).

## Project Memory Policy

Treat Graphify as the shared second memory for Codex, Claude, and any other coding agent working in this repository.

- At the start of any non-trivial project question, use `graphify query "<question>"` before broad file search when `graphify-out/graph.json` exists.
- Prefer `graphify explain "<concept>"` or `graphify path "<A>" "<B>"` before opening many raw files.
- After every code, prompt, theme, or documentation edit, run `graphify update .` before final handoff.
- When a task produces a durable lesson, architectural decision, correction, or useful answer, save it with `graphify save-result` and then run `graphify reflect` when several saved results have accumulated.
- If semantic docs/images need to be included in the graph, run a full `graphify .` extraction with a configured API key. The current graph can be maintained without an API key for code changes.
