FROM php:8.1.4-fpm-alpine

LABEL maintainer="Nazar Taran"

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY php.ini /usr/local/etc/php/
RUN docker-php-ext-configure pcntl \
    && docker-php-ext-install -j$(nproc) pcntl pdo_mysql
RUN apk update && apk add --no-cache supervisor
COPY supervisord.conf /etc/supervisor/
