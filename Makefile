build:
	docker-compose build
pull:
	docker-compose pull
start:
	docker-compose up -d && make composer-install
stop:
	docker-compose down --remove-orphans
restart:
	make stop && make start
composer-install:
	docker-compose exec php composer install --prefer-dist --no-scripts
migration:
	docker-compose exec php symfony console doctrine:migrations:migrate


