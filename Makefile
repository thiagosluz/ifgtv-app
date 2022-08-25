stop:
	docker-compose stop
shell:
	docker-compose exec app sh
start:
	docker-compose up --detach
destroy:
	docker-compose down --volumes
build:
	docker-compose up --detach --build
seed:
	docker-compose exec app php artisan db:seed
migrate:
	docker-compose exec app php artisan migrate:fresh --seed
start-log:
	docker-compose up
#run:
#	docker-compose run --rm

