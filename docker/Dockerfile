FROM php:8.2-fpm

ARG gid=1000
ARG uid=1000

ARG app_env=production

RUN \
    apt-get update && \
    apt-get install -y zip unzip curl git libpq-dev && \
    docker-php-ext-install pdo_pgsql opcache bcmath

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN \
    groupadd -g $gid local && \
    useradd -m -g $gid -u $uid local && \
    chown -R $uid:$gid /var/www/

USER $uid
WORKDIR /var/www/
