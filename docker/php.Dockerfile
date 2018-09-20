FROM php:5.6-apache

MAINTAINER Samsul Ma'arif <samsul@blankon.id>

COPY ./docker/php.ini /usr/local/etc/php
RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev \
 libpng-dev libmcrypt-dev mysql-client libcurl3-dev libicu-dev libxml2-dev libbz2-dev
RUN docker-php-ext-install mbstring mysqli pdo_mysql curl json intl gd xml zip bz2 opcache

COPY ./docker/tarwit.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/ports.conf /etc/apache2/ports.conf
COPY ./docker/apache2.conf /etc/apache2/apache2.conf

RUN usermod -s /bin/bash www-data 
 && groupmod -g 1005 www-data
 && usermod -u 1005 -g 1005 www-data 
 && chown -Rf www-data.www-data /var/run/apache2 
 && chown -Rf www-data.www-data /var/log/apache2

RUN a2enmod rewrite
 && a2ensite tarwit
 && service apache2 restart

# install composer
RUN curl -sS https://getcomposer.org/installer | php
 && mv composer.phar /usr/bin/composer

# cleanup
RUN rm -rf /var/cache/apt/archives/* && rm -rf /tmp/*

EXPOSE 8000

USER www-data:www-data

