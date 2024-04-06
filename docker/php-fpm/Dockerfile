FROM php:8.2-fpm

# Install common php extension dependencies
RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip

RUN apt-get dist-upgrade -y && apt-get update && apt-get install --fix-missing && apt-get upgrade -y && apt-get install -y \
    git \
    nano \
    curl \
    procps \
    acl \
    parallel \
    bash

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.0-RC1
RUN export PATH=~/.composer/vendor/bin:$PATH

# Type docker-php-ext-install to see available extensions
# Install opcache and pdo
RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo pdo_mysql

# Update pecl repository
RUN pecl channel-update pecl.php.net
# Install APUc
RUN pecl install apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime
RUN echo 'date.timezone = "Europe/Berlin"' > /usr/local/etc/php/php.ini

# ext intl
RUN apt-get install -y libicu-dev \
    && docker-php-ext-install intl

# ext curl for elasticsearch
RUN apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install curl

# ext soap
RUN apt-get install -y libxml2-dev  \
    && docker-php-ext-install soap

## install memcached
#RUN apt-get install -y memcached libmemcached-dev libmemcached11 build-essential
#RUN no | pecl install memcached-3.1.3
#RUN docker-php-ext-enable memcached

# math
RUN apt-get install -y libgmp-dev \
	&& ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h \
	&& docker-php-ext-install \
		gmp \
		bcmath

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www

RUN usermod -u 1000 www-data

RUN mkdir -p var/cache/prod var/cache/dev var/cache/test var/log \
   && chown -R www-data:www-data var/ \
   && chmod -R ug+rwX var/



EXPOSE 9000
