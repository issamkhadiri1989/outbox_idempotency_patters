kill: stop
	docker system prune
	docker network prune
	docker volume prune

init:
	docker network create proxy-net

stop:
	docker stop $$(docker ps -aq)

start:
	docker compose up -d --force-recreate

build:
	docker compose build --force-rm

