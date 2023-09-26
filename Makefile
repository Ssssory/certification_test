#!make
include .env

up:
	docker-compose up -d
local-up:
	docker-compose up
stop:
	docker-compose stop
bash:
	docker exec -it ${PROJECT_NAME}_app bash
bash-root:
	docker exec -it -u root ${PROJECT_NAME}_app bash
migrate:
	docker exec -it --user ${USER_PHP} ${PROJECT_NAME}_app bin/console doctrine:migrations:migrate
install:
	docker exec --user ${USER_PHP} ${PROJECT_NAME}_app composer install