# PayForge — Repository Agent Instructions

## Project purpose
PayForge is a public, educational payment-infrastructure demo. It demonstrates sound backend engineering: API design, provider integrations, transaction state management, idempotency, ledger correctness, webhook delivery, testing, and operational discipline.

This is a demonstration project. Do not imply that it is PCI DSS certified, production-ready for real funds, or approved for live payment processing unless the repository contains independently verifiable evidence.

## Repository architecture
- `apps/api`: Laravel API. It is the system of record for merchants, transactions, wallets, ledger entries, commissions, reserves, and payment state.
- `apps/provider-service`: Node.js + TypeScript service responsible for provider-facing communication, provider adapters, callback normalization, and provider health.
- `infrastructure`: Docker, Nginx, database initialization, and local development infrastructure.
- `docs`: architecture decisions, database design, API contracts, and operational documentation.
- `.agents/skills`: reusable task playbooks. Read the relevant `SKILL.md` before substantial work in that area.

Preserve this separation. The provider service must not independently update Laravel-owned transaction, wallet, or ledger tables. It communicates outcomes to the Laravel API through an authenticated internal interface or documented event contract.

### Architecture style
Use standard Laravel application structure, not Domain-Driven Design. Keep code in the framework's conventional folders (controllers, form requests, API resources, models, policies, jobs, and services/actions when warranted). Do not introduce DDD layering such as `app/Domain`, bounded contexts, aggregates, domain events, or repository abstractions unless a task explicitly requires them.

## Working rules
1. Read this file and the nearest nested `AGENTS.md` before editing. More specific instructions supplement this file; if instructions conflict, follow the more specific file unless it violates a security or financial invariant here.
2. Inspect the existing code, migrations, tests, Composer/npm scripts, Docker setup, and docs before proposing changes. Do not assume a planned file or feature already exists.
3. Make focused, incremental changes. Avoid unrelated refactors, dependency upgrades, renaming, or formatting churn.
4. Before coding, summarize the intended approach and list affected files when the task is broad or changes multiple modules.
5. Implement one vertical slice at a time: schema, business logic, HTTP/worker integration, tests, and documentation.
6. Follow existing naming, namespaces, formatting, error conventions, and API response patterns.
7. Do not introduce a new package when the existing framework or codebase can reasonably solve the problem.
8. Do not leave TODO-only implementations, fake success responses, disabled tests, or silently swallowed exceptions.
9. Do not claim a command or test passed unless you ran it and observed a successful result. If unable to run it, say why.
10. Update relevant docs and `.env.example` files when behavior, configuration, API contracts, or setup changes.

## Non-negotiable financial and data invariants
- Store monetary values as integer minor units (`BIGINT` where appropriate), never floating-point values.
- Use the currency's configured minor-unit exponent. Do not assume every currency has two decimal places (for example, JPY and IDR commonly use zero).
- Never use PHP floats or JavaScript `number` arithmetic for monetary calculations. Use integer-safe arithmetic or a suitable decimal/integer library and validate bounds.
- Every posted double-entry journal must balance per currency: total debits equal total credits.
- Posted ledger entries are immutable. Correct mistakes with explicit reversal/adjustment entries, not edits or deletes.
- A transaction state change must be validated against an explicit transition policy.
- Make externally retried operations idempotent. Use database-enforced uniqueness where appropriate; do not rely only on an in-memory check.
- Use database transactions and appropriate row locks for concurrent balance-affecting operations.
- Never trust a provider callback based only on its payload. Verify its signature/authenticity and validate amount, currency, merchant, provider reference, and transaction relationship.
- Treat provider callbacks and webhook delivery as at-least-once. Design for duplicates and out-of-order delivery.
- Keep an auditable event history for important state transitions.
- Do not log API secrets, passwords, authorization headers, full payment credentials, or sensitive personal data.

## Security and privacy
- Never commit real credentials, private keys, production URLs containing secrets, customer data, or `.env` files.
- Use `.env.example` with safe placeholders. Validate required configuration at startup.
- Hash merchant API secrets at rest; show the raw secret only at creation time if that is the established design.
- Use authentication, authorization, tenant scoping, input validation, rate limiting, and least privilege where applicable.
- Avoid exposing stack traces, SQL errors, internal provider credentials, or sensitive metadata in API responses.
- Use synthetic fixtures only. Never copy employer code, schema, screenshots, business logic, credentials, or customer data into this public repository.

## Database and migrations
- Use explicit foreign keys, unique constraints, indexes, nullability, and deletion behavior.
- Prefer additive, reversible migrations. Do not rewrite migrations that may already have been applied unless the task explicitly establishes that they are disposable.
- Consider concurrency and query plans for high-contention or frequently queried tables.
- Store timestamps consistently (UTC in persistence where practical); convert at API/display boundaries.
- Keep historical snapshots needed to explain a financial transaction even if related configuration later changes.

## API and compatibility
- Validate all external input at the boundary.
- Keep API versioning and response conventions consistent.
- Return safe, actionable errors with appropriate HTTP status codes.
- Do not expose internal numeric IDs or provider-specific details unless the API contract requires them.
- Document authentication, idempotency, validation, response examples, and error behavior for new endpoints.

## Testing expectations
- Add tests for happy paths, validation failures, authorization/tenant isolation, duplicate requests, concurrency-sensitive behavior where feasible, and failure/retry behavior.
- Financial tests must assert exact integer amounts and balanced journals.
- Provider tests must cover valid, invalid, duplicated, delayed, and malformed callbacks.
- Avoid tests that depend on live payment providers or external network access. Use deterministic fakes/mocks.
- Run the narrowest relevant test first, then the full relevant suite and static checks.

## Completion report
At the end of a task, report:
- What changed.
- Important design decisions and assumptions.
- Migrations or environment changes required.
- Commands/tests actually run and their results.
- Known limitations or follow-up work.
