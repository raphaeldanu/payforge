# PayForge agent skills

Skills are reusable task playbooks. Keep repository-wide rules in `AGENTS.md`; put task-specific procedures in each skill's `SKILL.md`.

## Layout
Each skill lives in its own directory:

```text
.agents/
  skills/
    payment-domain/SKILL.md
    laravel-api/SKILL.md
    provider-adapter/SKILL.md
    database-migrations/SKILL.md
    testing/SKILL.md
    docker-local-dev/SKILL.md
```

Before a task, read the skill whose description matches the work. Skills are guidance, not permission to ignore repository instructions or security/financial invariants.

Some coding agents discover skills automatically from `.agents/skills`; others require you to configure or invoke them explicitly. If your agent does not discover them, point it to the relevant `SKILL.md` or copy/adapt the skill into that agent's supported skill directory. Keep one canonical copy in this repository.
