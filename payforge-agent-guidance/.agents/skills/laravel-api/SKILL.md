---
name: laravel-api
description: Implement or refactor Laravel API endpoints, Form Requests, API Resources, policies, services, jobs, Eloquent models, and feature tests in apps/api.
---

# Laravel API Skill

## Workflow
1. Read root and `apps/api/AGENTS.md`.
2. Inspect composer dependencies, Laravel version, route conventions, namespaces, and test framework.
3. Trace a similar existing endpoint/module and follow its established patterns.
4. Define request validation, authorization, domain action/service, persistence, response resource, and failure behavior.
5. Add feature and unit tests, including unauthorized and cross-merchant access.
6. Run formatter, targeted tests, and broader tests.

## Implementation guidance
- Keep controllers thin; put business decisions in domain actions/services.
- Use Form Requests for validation, Policies/Gates for authorization, and API Resources for output.
- Scope queries by the authenticated merchant/tenant.
- Use explicit transactions for multi-write operations.
- Dispatch retryable jobs only after required data is committed.
- Avoid mass assignment of sensitive or ownership fields from untrusted input.
- Do not expose model internals or exception messages by returning models/exceptions directly.

## Completion
List changed routes, migrations, authorization rules, test coverage, and commands actually run.
