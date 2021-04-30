FROM php:7.4-apache

RUN apt-get update \
  && apt-get install -y zip unzip libpq-dev \
  && docker-php-ext-install pdo_pgsql \
  && a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
