FROM composer:latest AS build

WORKDIR /app
COPY . /app
RUN composer install --no-dev --optimize-autoloader

FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip sqlite3 libsqlite3-dev libpng-dev libonig-dev

RUN docker-php-ext-install pdo pdo_sqlite mbstring zip exif pcntl

COPY --from=build /app /var/www

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000