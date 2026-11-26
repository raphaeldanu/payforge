---
name: provider-adapter
description: Build or change a payment provider adapter, upstream HTTP client, callback handler, signature verification, status normalization, or retry policy in apps/provider-service.
---

# Provider Adapter Skill

## Workflow
1. Read root and `apps/provider-service/AGENTS.md`.
2. Inspect the provider service's current interfaces, HTTP client, validation library, logging, and test runner.
3. Define a provider-neutral contract before implementing provider-specific behavior.
4. Implement request mapping, response mapping, callback parsing, signature verification, and error classification separately.
5. Add tests using mocked upstream responses and synthetic callback payloads.
6. Document configuration, callback contract, timeout/retry behavior, and operational signals.

## Safety checklist
- Credentials are loaded from validated environment/config and never logged.
- TLS verification remains enabled.
- Connection and response timeouts are explicit.
- Retries are bounded and only used when safe.
- A timeout is represented as an unknown outcome when provider execution may have occurred.
- Callback signature and replay checks follow provider documentation.
- Duplicate callbacks are idempotent.
- Provider-specific statuses are normalized and documented.
- No direct database writes to Laravel-owned financial tables.

## Completion
Report adapter contract, failure mapping, callback security, tests, and any assumptions about provider documentation.
