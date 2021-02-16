FROM php:7.2-fpm-stretch

ENV DEBIAN_FRONTEND noninteractive

## Timezon
ENV TZ Asia/Tokyo
RUN echo "${TZ}" > /etc/timezone \
  && dpkg-reconfigure -f noninteractive tzdata

COPY docker/php-fpm/php.ini /usr/local/etc/php/

## Basic Install
RUN apt-get update && \
  apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev zlib1g-dev mariadb-client \
  git zip unzip vim libpq-dev supervisor iputils-ping net-tools cron && \
  docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
  docker-php-ext-install -j$(nproc) gd exif pdo_mysql pdo_pgsql && \
  curl -sL https://deb.nodesource.com/setup_11.x | bash - && \
  apt-get install -y nodejs && \
  npm install npm@latest -g && \
  npm install --save-dev cross-env

COPY docker/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf
COPY docker/supervisor/laravel-cron.conf /etc/supervisor/conf.d/laravel-cron.conf
COPY docker/php-fpm/cron.d/crontab /var/spool/cron/crontabs/root

## Permission
RUN mkdir -p /var/www/html/src
COPY ./ /var/www/html/src
WORKDIR /var/www/html/src
RUN chown -R root:crontab /var/spool/cron/crontabs/root
RUN chmod 600 /var/spool/cron/crontabs/root

#Composer install
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN cp .env.example .env
RUN composer install
RUN php artisan key:generate
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan storage:link

## Laravel Permission
RUN chmod -R a+w storage/ bootstrap/cache
RUN chown -R www-data:www-data storage
RUN chmod -R 775 storage
RUN chmod -R 777 public/
