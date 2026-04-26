FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    icu-dev \
    libpq-dev \
    zip \
    libzip-dev \
    zlib-dev

RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/symfony