Задеплоенная версия доступна здесь: [todo-laravel.194-87-252-222.nip.io](http://todo-laravel.194-87-252-222.nip.io/).

```sh
git clone https://github.com/try-again-later/Todo-Laravel
cd Todo-Laravel

# build frontend assests
docker-compose \
    -f ./docker/docker-compose.yml \
    --env-file ./.env \
    run --rm npm "npm i && npm run build"

# start backend services
cp .env.example .env
docker-compose \
    -f ./docker/docker-compose.yml \
    --env-file ./.env \
    up -d --build app webserver database


# install backend dependencies, run migrations
docker-compose \
    -f ./docker/docker-compose.yml \
    --env-file ./.env \
    exec -it app bash

composer install
php artisan key:generate
php artisan migrate:fresh
```

После этого приложение будет доступно по ссылке [localhost:8080](http://localhost:8080).
