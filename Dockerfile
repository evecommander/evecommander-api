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
    postgresql-dev \
  && pecl channel-update pecl.php.net \
  && pecl install apcu \
  && docker-php-ext-install -j$(nproc) bz2 \
    curl \
    mbstring \
    pdo \
    pgsql \
    pdo_pgsql \
    bcmath \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install gd

# Memory Limit
RUN echo "memory_limit=2048M" > $PHP_INI_DIR/conf.d/memory-limit.ini
RUN echo "max_execution_time=900" >> $PHP_INI_DIR/conf.d/memory-limit.ini
RUN echo "extension=apcu.so" > $PHP_INI_DIR/conf.d/apcu.ini
RUN echo "post_max_size=20M" >> $PHP_INI_DIR/conf.d/memory-limit.ini
RUN echo "upload_max_filesize=20M" >> $PHP_INI_DIR/conf.d/memory-limit.ini

# Time Zone
RUN echo "date.timezone=${PHP_TIMEZONE:-UTC}" > $PHP_INI_DIR/conf.d/date_timezone.ini

# Display errors in stderr
RUN echo "display_errors=stderr" > $PHP_INI_DIR/conf.d/display-errors.ini

# Disable PathInfo
RUN echo "cgi.fix_pathinfo=0" > $PHP_INI_DIR/conf.d/path-info.ini

# Disable expose PHP
RUN echo "expose_php=0" > $PHP_INI_DIR/conf.d/path-info.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD . /var/www/html
WORKDIR /var/www/html

RUN composer install
RUN php artisan optimize

RUN chmod -R 777 /var/www/html/storage

RUN touch /var/log/cron.log

ADD deploy/cron/artisan-schedule-run /etc/cron.d/artisan-schedule-run
RUN chmod 0644 /etc/cron.d/artisan-schedule-run
RUN chmod +x /etc/cron.d/artisan-schedule-run
RUN touch /var/log/cron.log

CMD ["/bin/sh", "-c", "php-fpm -D | tail -f storage/logs/laravel.log"]