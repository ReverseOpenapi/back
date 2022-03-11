FROM php:8.1-apache

ENV PUBSUB_EMULATOR_HOST host.docker.internal:8085
ENV PUBSUB_PROJECT_ID reverse-openapi

RUN a2enmod rewrite \
    && a2enmod headers\
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql