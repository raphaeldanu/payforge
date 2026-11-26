---
name: database-migrations
description: Create or modify PayForge database migrations, indexes, constraints, Eloquent persistence models, seeders, or database design documentation.
---

# Database Migrations Skill

## Workflow
1. Read root `AGENTS.md` and the relevant app instructions.
2. Inspect existing migrations and schema docs; do not assume the design document is the current schema.
3. Identify ownership, primary/foreign keys, uniqueness, nullability, deletion behavior, query patterns, and expected table growth.
4. Design constraints and indexes alongside the columns.
5. Implement an additive migration and update models/factories/seeders as needed.
6. Test fresh migration and rollback where safe; test uniqueness and foreign-key behavior.
7. Update the schema documentation/ERD.

## PayForge rules
- Use BIGINT integer minor units for money; never floating-point columns.
- Include currency identity for monetary records.
- Use unique constraints for idempotency and provider references within the correct scope.
- Use foreign keys and deliberate delete behavior.
- Keep posted ledger rows immutable at the application layer.
- Store timestamps consistently and document timezone assumptions.
- Preserve snapshots needed for historical financial explanations.
- Avoid destructive migration operations unless explicitly required and backed by a safe migration plan.

## Completion
Summarize schema changes, constraints/indexes, migration commands run, and rollback considerations.
