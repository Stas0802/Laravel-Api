FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt update && apt install -y \
    zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd

COPY . /var/www/html
