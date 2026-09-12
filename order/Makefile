enter:
	docker compose exec php bash

start:
	docker compose up -d --no-recreate --remove-orphans

down:
	docker compose down --remove-orphans

build: 
	docker compose build --no-cache --force-rm

install:
	docker compose exec php composer install --no-cache --no-interaction --optimize-autoloader

stop:
	docker compose stop

info:
	docker compose exec php php -v
	
list:
	docker compose ps
