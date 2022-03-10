FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends git unzip libzip-dev && \
    docker-php-ext-install mysqli pdo pdo_mysql zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    a2enmod rewrite && a2enmod headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN a2enmod rewrite \
    && a2enmod headers\
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

CMD composer install; apache2-foreground; php bin/console d:s:u --force; symfony serve;