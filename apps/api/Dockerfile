FROM php:8.5.0RC3-cli-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        bcmath \
        intl \
        gd \
        opcache \
        pcntl \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

    WORKDIR /var/www/html

    COPY apps/api/ ./

    RUN composer install \
        --no-interaction \
        --prefer-dist

    RUN chown -R www-data:www-data storage bootstrap/cache

    EXPOSE 9000

    CMD ["php-fpm"]
