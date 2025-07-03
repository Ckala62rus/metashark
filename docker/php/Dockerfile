# Многоэтапная сборка
FROM php:8.2-fpm

# Устанавливаем все зависимости включая zip/unzip/7z
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    unzip \
    zip \
    p7zip-full \
    bash \
    nano \
    $PHPIZE_DEPS \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Включаем и устанавливаем необходимые PHP расширения
RUN docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    intl \
    opcache \
    soap \
    sockets \
    exif \
    zip \
    pcntl \
    bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-source delete

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer --2 \
    && chmod +x /usr/local/bin/composer

# For debugger PHPStorm
RUN pecl install xdebug && docker-php-ext-enable xdebug \
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.remote_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


# Устанавливаем только необходимые runtime-зависимости
RUN apt-get update && apt-get install -y --no-install-recommends \
    bash \
    nano \
    git \
    unzip \
    zip \
    libpq5 \
    libzip4 \
    libonig5 \
    && rm -rf /var/lib/apt/lists/*

# Настройка PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    echo "memory_limit = 512M" >> "$PHP_INI_DIR/conf.d/memory-limit.ini" && \
    echo "opcache.enable=1" >> "$PHP_INI_DIR/conf.d/opcache.ini" && \
    echo "opcache.memory_consumption=128" >> "$PHP_INI_DIR/conf.d/opcache.ini" && \
    echo "opcache.interned_strings_buffer=8" >> "$PHP_INI_DIR/conf.d/opcache.ini" && \
    echo "opcache.max_accelerated_files=10000" >> "$PHP_INI_DIR/conf.d/opcache.ini"

WORKDIR /var/www
