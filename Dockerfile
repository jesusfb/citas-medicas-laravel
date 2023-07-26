FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    zip \
    unzip \
    ssh \
    libzip-dev \
    autoconf \
    pkg-config \
    libssl-dev \
    libgd3 \
    libpng-dev
    
RUN apt-get install -y nodejs npm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-install sockets
RUN docker-php-ext-install pdo_mysql zip exif pcntl gd

RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/*



RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data . /var/www/html

USER www-data

EXPOSE 80


