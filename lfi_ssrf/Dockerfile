FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    iputils-ping \
    netcat \
    && docker-php-ext-install curl
RUN a2enmod rewrite

COPY ./src /var/www/html/

RUN chown -R www-data:www-data /var/www/html
