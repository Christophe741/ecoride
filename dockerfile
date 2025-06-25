FROM php:8.1-apache
RUN apt-get update \
    && apt-get install -y git unzip libssl-dev pkg-config \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*
COPY . /var/www/html/
RUN composer install --no-interaction --prefer-dist --working-dir=/var/www/html

