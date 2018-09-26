FROM php:7.2-fpm-alpine3.8

RUN apk --no-cache add \
    bzip2-dev \
    curl-dev \
    autoconf \
    gcc \
    g++ \
    imagemagick-dev \
    libtool \
    make \
    postgresql-client \
  && docker-php-ext-install -j$(nproc) bz2 \
  && docker-php-ext-install -j$(nproc) curl \
  && docker-php-ext-install -j$(nproc) mbstring \
  && docker-php-ext-install -j$(nproc) pdo \
  && docker-php-ext-install -j$(nproc) pdo_mysql \
  && pecl install imagick \
  && docker-php-ext-enable imagick

COPY composer.lock composer.json /var/www/

COPY database /var/www/database

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache