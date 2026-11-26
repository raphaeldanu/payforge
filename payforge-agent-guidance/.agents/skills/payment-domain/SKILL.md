---
name: payment-domain
description: Design or implement PayForge payment flows, transaction states, idempotency, ledger posting, refunds, commissions, rolling reserves, or reconciliation.
---

# Payment Domain Skill

## Workflow
1. Read root `AGENTS.md`, `apps/api/AGENTS.md`, and the relevant architecture/database docs.
2. Trace the current implementation and tests before changing anything.
3. Identify the source of truth, state transitions, database constraints, and retry boundaries.
4. Write down invariants and failure cases before implementation.
5. Implement the smallest complete vertical slice and add deterministic tests.
6. Update API and architecture docs to match the implementation.

## Required design checks
- Amounts are integer minor units and tied to a currency exponent.
- Idempotency is persisted and protected by a unique constraint.
- State transitions are explicit and invalid transitions are rejected.
- Concurrent balance-affecting operations use transactions and appropriate row locks.
- Posted journals balance per currency and cannot be edited/deleted.
- Corrections use reversal or adjustment journals.
- External calls do not occur while holding long database transactions.
- Provider timeouts are ambiguous outcomes, not automatically failed payments.
- Duplicate and out-of-order callbacks are safe.
- Audit/event history records meaningful changes.

## Do not
- Use floating point for money.
- Treat a wallet balance cache as the financial source of truth.
- Allow a provider service to mutate Laravel-owned financial tables.
- Trust client-supplied merchant IDs without authorization and tenant scoping.
- silently swallow a posting or callback failure.

## Deliverable
Provide a concise flow description, invariants, schema changes, tests run, and any unresolved edge cases.
