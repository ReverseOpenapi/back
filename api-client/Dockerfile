FROM php:8.1-apache

RUN a2enmod rewrite \
    && a2enmod headers\
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql