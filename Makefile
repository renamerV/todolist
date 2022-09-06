init: down pull up

up:
	docker-compose up -d
	docker-compose exec app composer install
	docker-compose exec app php artisan migrate

down:
	docker-compose down --remove-orphans

pull:
	docker-compose pull

build:
	docker-compose build

frontend:
	npm run watch

websocket:
	php artisan websockets:serve
