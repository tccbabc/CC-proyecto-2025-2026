.PHONY: build up down test migrate composer

build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

composer:
	docker compose exec app composer $(cmd)

migrate:
	docker compose exec app php artisan migrate --force

test:
	docker compose exec app php artisan test
