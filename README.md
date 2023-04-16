```sh
git clone https://github.com/try-again-later/Todo-Laravel
cd Todo-Laravel

cp .env.example .env
docker-compose -f ./docker/docker-compose.yml --env-file ./.env up -d --build

docker-compose -f ./docker/docker-compose.yml --env-file ./.env exec -it app bash
composer install
php artisan key:generate
php artisan migrate:fresh
```

После этого приложение будет доступно по ссылке [localhost:8080](http://localhost:8080).
