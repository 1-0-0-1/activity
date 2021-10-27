FROM php:7.4-fpm

RUN apt-get update && apt-get install -y mc unzip git

RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev && docker-php-ext-install zip

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql pdo_mysql

RUN apt-get update && docker-php-ext-install mysqli

RUN apt-get update && docker-php-ext-install opcache

RUN apt-get update && docker-php-ext-install gettext

RUN apt-get update && apt-get install -y libicu-dev && docker-php-ext-install intl

RUN apt-get update && apt-get install -y libpng-dev && docker-php-ext-install gd

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY php/conf.d/ /usr/local/etc/php/conf.d/

COPY php/php.ini /usr/local/etc/php/php.ini

RUN curl -sS https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer | php -- --quiet --install-dir=/usr/local/bin --filename=composer --2

RUN curl -sS https://get.symfony.com/cli/installer | bash -s -- --install-dir=/usr/local/bin

RUN git config --global user.email "anonymous@anonymous.com" && git config --global user.name "Anonymous"

WORKDIR /var/www/html


