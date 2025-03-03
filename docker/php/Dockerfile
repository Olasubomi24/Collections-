FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    zip

WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data writable \
    && chmod -R 755 writable
