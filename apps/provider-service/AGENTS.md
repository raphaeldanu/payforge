# Provider Service — Agent Instructions

These instructions apply to `apps/provider-service` and supplement the repository-root `AGENTS.md`.

## Responsibilities and boundaries
- This service owns provider-specific HTTP communication, provider adapters, callback parsing/normalization, provider health checks, and integration-level retry behavior.
- Laravel remains the system of record for merchants, payment transactions, wallet balances, ledger entries, commissions, and reserves.
- Do not connect this service directly to Laravel's business database or write Laravel-owned tables.
- Communicate with Laravel through a documented, authenticated internal API or event contract.
- Keep provider-specific payloads behind adapter interfaces. Do not leak provider-specific response formats into the internal contract.

## TypeScript conventions
- Follow the TypeScript configuration, Node version, module system, package manager, and scripts already in the repository.
- Keep strict type checking enabled. Avoid `any`; if unavoidable at an untrusted boundary, narrow and validate immediately.
- Parse and validate environment variables at startup. Do not scatter direct `process.env` access throughout business logic.
- Separate transport, provider adapters, data mapping/normalization, and application orchestration. Use standard layered service structure, not Domain-Driven Design.
- Use dependency injection or explicit function parameters for HTTP clients, clocks, loggers, and configuration so tests remain deterministic.
- Keep handlers small. Validate request shape before business processing.

## Provider integration safety
- Set explicit connection and response timeouts.
- Use bounded retries with backoff and jitter only for retryable failures. Do not blindly retry non-idempotent provider operations.
- Use provider idempotency/reference keys when supported.
- Treat network timeouts as an unknown outcome, not proof that the provider failed. Reconcile/query provider status before creating a new payment attempt where possible.
- Verify callback signatures using constant-time comparison and the provider's documented signing algorithm.
- Validate callback timestamp/replay window where the provider supports it.
- Normalize provider statuses into a small, documented internal status vocabulary.
- Preserve a safe provider reference and correlation ID for support and reconciliation.
- Redact credentials, signatures, authorization headers, and sensitive payload fields from logs.
- Never log full callback payloads by default; log only a redacted, structured subset.

## HTTP service conventions
- Expose health/readiness endpoints without leaking environment variables or dependency secrets.
- Apply request size limits, validation, and appropriate rate limits to public callback routes.
- Use explicit error types and map them to safe HTTP responses.
- Avoid returning raw upstream provider error bodies to callers.
- Ensure shutdown closes servers and outstanding clients gracefully where the runtime supports it.

## Tests and quality
- Use the configured test runner (for example Vitest) and existing scripts.
- Test adapter mapping, signature validation, replay protection, timeout behavior, retries, duplicate callbacks, and malformed payloads.
- Mock provider HTTP responses. Tests must not require provider credentials or live external services.
- Run type checking, tests, and build before finishing.

## Before finishing
Update provider contract documentation and `.env.example` when configuration or callback behavior changes. Report commands actually executed.
