FROM php:8.0-fpm-alpine
RUN docker-php-ext-install pdo_mysql
COPY . /var/www/html
EXPOSE 80