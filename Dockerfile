ARG PHP_VERSION
FROM php:${PHP_VERSION}-apache
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install pdo pdo_mysql

