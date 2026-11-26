---
name: docker-local-dev
description: Change PayForge Dockerfiles, Compose services, Nginx configuration, local development scripts, health checks, or environment templates.
---

# Docker Local Development Skill

## Workflow
1. Read root `AGENTS.md` and inspect the existing Compose files, Dockerfiles, Makefile, and env templates.
2. Preserve the intended service boundaries: Nginx, Laravel API/worker, Node provider service, MySQL, Redis, and local mail catcher where configured.
3. Check build context, COPY paths, bind mounts, named volumes, file permissions, exposed ports, and service DNS names.
4. Add health checks and readiness dependencies where useful; remember `depends_on` alone may only order startup.
5. Keep secrets out of image layers and source control. Use `.env.example` placeholders.
6. Validate Compose syntax and build the affected service(s).
7. Update setup docs with exact commands and destructive-volume warnings.

## Safety
- Do not bake secrets into Docker images or build arguments.
- Do not expose database/Redis ports publicly by default unless local access requires it.
- Warn before commands that delete named volumes or local database data.
- Use pinned major/minor image versions intentionally; do not upgrade all services incidentally.

## Completion
Report services/files changed, validation/build commands run, port or env changes, and any data-loss risk.
