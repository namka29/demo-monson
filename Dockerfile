# PHP-FPM runtime for Laravel + Filament (MySQL PDO, common extensions).
FROM php:8.3-fpm-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        bcmath \
        intl \
        zip \
        opcache \
        pcntl \
        gd \
        exif \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Node.js 22 + npm (Vite) — khớp service `node` trong compose.yml
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && node --version \
    && npm --version

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/php/entrypoint.sh /usr/local/bin/laravel-docker-entrypoint
RUN chmod +x /usr/local/bin/laravel-docker-entrypoint

COPY docker/php/conf.d/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

ENTRYPOINT ["laravel-docker-entrypoint"]
CMD ["php-fpm"]
