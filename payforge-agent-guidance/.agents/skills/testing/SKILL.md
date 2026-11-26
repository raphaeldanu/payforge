---
name: testing
description: Plan or implement unit, feature, integration, contract, or concurrency tests for PayForge Laravel and TypeScript services.
---

# Testing Skill

## Workflow
1. Read root and app-specific `AGENTS.md`.
2. Inspect the existing test framework, helpers, factories, and CI commands.
3. Identify observable behavior and failure modes before writing tests.
4. Use deterministic fixtures, fake clocks, fake queues, and mocked HTTP clients.
5. Cover success, validation, authorization, duplicate/retry, and failure paths.
6. Run targeted tests, then the relevant full suite and static checks.

## Critical PayForge cases
- Repeated idempotency key returns the documented result and does not create duplicate financial effects.
- Same idempotency key with a different request body is rejected according to the API contract.
- Concurrent operations cannot overspend or double-post.
- Ledger debits equal credits for every currency.
- Invalid transaction state transitions are rejected.
- Invalid callback signatures are rejected; duplicate valid callbacks do not duplicate effects.
- Tenant A cannot read or mutate Tenant B's resources.
- Provider timeouts and retryable/non-retryable errors map correctly.
- Tests never call real providers or require real credentials.

## Completion
List the cases added, commands run, and any behavior that remains untested.
