FROM php:8.5-fpm

# PHP 8.5 compiles opcache into the binary itself, so it must NOT be passed to
# docker-php-ext-install (it emits no modules/*.so and the build fails).
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
        pcntl \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY scripts/api-entrypoint.sh /usr/local/bin/payforge-entrypoint
RUN chmod +x /usr/local/bin/payforge-entrypoint

    WORKDIR /var/www/html

    COPY apps/api/ ./

    RUN composer install \
        --no-interaction \
        --prefer-dist

    RUN chown -R www-data:www-data storage bootstrap/cache

    EXPOSE 9000

    ENTRYPOINT ["/usr/local/bin/payforge-entrypoint"]

    CMD ["php-fpm"]
