# Define PHP extensions as environment variable
ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql dom pcntl"

# Stage 1: Build stage
FROM composer:2.6.5 as build
ARG PHP_EXTS

RUN mkdir -p /app
WORKDIR /app

RUN addgroup -S composer \
    && adduser -S composer -G composer \
    && chown -R composer /app \
    && apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} openssl ca-certificates libxml2-dev oniguruma-dev \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && apk del build-dependencies

USER composer

COPY --chown=composer composer.json composer.lock ./

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY --chown=composer . .
COPY --chown=composer .env.example .env

RUN composer install --no-dev --prefer-dist

# Stage 2: Server stage
FROM php:8.2-fpm as server
ENV APP_NAME=Starter
ENV APP_KEY='base64:LsPVrOjJwn84sLuXQDbay5os4JIaZ34kSRz83KRn990='
ENV APP_ENV=development
ENV APP_DEBUG=true
ENV ACCESS_TOKEN_EXPIRATION=86400

ARG PHP_EXTS
WORKDIR /var/www

RUN apt-get update && apt-get install -y --no-install-recommends \
    openssl \
    nginx \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    zlib1g-dev \
    libzip-dev \
    locales \
    libonig-dev \
    lua-zlib-dev \
    libmemcached-dev \
    supervisor \
    net-tools

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

COPY --chown=www-data:www-data --from=build /app /var/www

RUN cp docker/supervisor/supervisor.conf /etc/supervisord.conf
RUN cp docker/php/app.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx/app.conf /etc/nginx/sites-enabled/default

EXPOSE 80 9000

ENTRYPOINT ["sh", "./docker/entrypoint.sh"]
