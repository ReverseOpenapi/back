FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends git unzip libzip-dev && \
    docker-php-ext-install mysqli pdo pdo_mysql zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    a2enmod rewrite && a2enmod headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

CMD composer install; php bin/console messenger:consume sqs
