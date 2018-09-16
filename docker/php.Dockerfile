FROM php:5.6-apache

MAINTAINER Samsul Ma'arif <samsul@blankon.id>

COPY ./docker/php.ini /usr/local/etc/php
RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev \
 libpng-dev libmcrypt-dev mysql-client libcurl3-dev libicu-dev libxml2-dev libbz2-dev
RUN docker-php-ext-install mbstring mysqli pdo_mysql curl json intl gd xml zip bz2 opcache


COPY ./docker/tarwit.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/ports.conf /etc/apache2/ports.conf
#COPY ./docker/hosts /etc/hosts

RUN a2enmod rewrite
#RUN a2ensite tarwit
RUN service apache2 restart

# install composer
RUN curl -sS https://getcomposer.org/installer | php 
RUN mv composer.phar /usr/bin/composer

# cleanup
RUN rm -rf /var/cache/apt/archives/* && rm -rf /tmp/*

EXPOSE 8000

RUN usermod -s /bin/bash www-data
RUN groupmod -g 1005 www-data
RUN usermod -u 1005 -g 1005 www-data
USER www-data:www-data

