# Documentation — Agent Instructions

These instructions apply to `docs` and supplement the repository-root `AGENTS.md`.

- Write for an engineer who has just cloned the public repository.
- Keep architecture docs consistent with the code that actually exists. Clearly label planned functionality as planned; do not document it as implemented.
- Explain ownership boundaries between Laravel and the Node provider service.
- For API docs, include authentication, idempotency requirements, request/response examples, validation errors, and retry semantics.
- For financial flows, include a worked example with exact minor-unit amounts and show that debits equal credits.
- Use synthetic names, references, and data only.
- Record meaningful architectural decisions as short ADRs under `docs/architecture/decisions/` if that directory exists or is appropriate.
- Prefer concise diagrams and sequence flows when they materially clarify asynchronous processing.
- Do not claim compliance, certification, production readiness, or real provider partnerships without evidence.
