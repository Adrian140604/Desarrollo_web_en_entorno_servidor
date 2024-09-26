FROM php:8.2-apache

# Instala Xdebug y las dependencias necesarias
RUN pecl install -o -f xdebug \
    && docker-php-ext-enable xdebug


