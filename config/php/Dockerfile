FROM php:8.2-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./src/composer.* /var/www/html/

RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

COPY ./src/. /var/www/html/

RUN composer dump-autoload --optimize