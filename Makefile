
.PHONY: up down build restart logs ps shell migrate test fresh

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

restart:
	docker compose restart

logs:
	docker compose logs -f

ps:
	docker compose ps

shell:
	docker compose exec api sh

migrate:
	docker compose exec api php artisan migrate

test:
	docker compose exec api php artisan test
	docker compose exec provider-service npm test

fresh:
	docker compose exec api php artisan migrate:fresh --seed
