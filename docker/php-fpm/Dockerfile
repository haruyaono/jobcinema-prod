FROM php:7.2-fpm-stretch

ENV DEBIAN_FRONTEND noninteractive

## Timezon
ENV TZ Asia/Tokyo
RUN echo "${TZ}" > /etc/timezone \
   && dpkg-reconfigure -f noninteractive tzdata

COPY docker/php-fpm/php.ini /usr/local/etc/php/

## Basic Install
RUN apt-get update \
  && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    zlib1g-dev \
    mariadb-client \
    git \
    zip \
    unzip \
    vim \
    libpq-dev \
    supervisor \
    redis-server \
    iputils-ping \
    net-tools \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd exif pdo_mysql pdo_pgsql \
    && curl -sL https://deb.nodesource.com/setup_11.x | bash - \
    && apt-get install -y nodejs \
    && npm install npm@latest -g \
    && npm install --save-dev cross-env

COPY docker/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

## Permission
RUN mkdir -p /var/www/html/src
ADD ./ /var/www/html/src
WORKDIR /var/www/html/src

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
RUN chown -R www-data:www-data /var/www/html/src

#Composer install
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require hirak/prestissimo
RUN cp .env.example .env
RUN composer install
RUN php artisan key:generate
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN composer dump-autoload
RUN php artisan clear-compiled

## Laravel Permission
RUN chmod -R a+w storage/ bootstrap/cache
RUN chown -R www-data:www-data storage
RUN chmod -R 775 storage
RUN chmod -R 775 storage
RUN service supervisor start
