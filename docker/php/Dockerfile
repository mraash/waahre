FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y libpq-dev libzip-dev zip

RUN pecl install             xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql \
    && docker-php-ext-enable  pdo pdo_mysql pdo_pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-enable  zip  
