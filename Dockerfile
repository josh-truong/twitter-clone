ARG PHP_VERSION
FROM php:${PHP_VERSION}-apache
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install pdo pdo_mysql

COPY . /src
RUN rm -rf /var/www/html
RUN mv /src /var/www/html
RUN find /var/www/html/ -type d -exec chmod 755 {} \;
RUN find /var/www/html/ -type f -exec chmod 644 {} \;
