FROM php:8.0-apache
# FROM php:7.4-apache

COPY . /var/www/html/
WORKDIR /var/www/html/

# ◆追加
# PHPの拡張機能と必要なツールをインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    graphviz \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Composerをインストール
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.jsとnpmをインストール
RUN curl -sL https://deb.nodesource.com/setup_15.x | bash -
RUN apt-get install -y nodejs
# ◆ここまで。

RUN chown -R www-data:www-data /var/www/html \
&& a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ●追加
RUN composer install

COPY ./apache_file/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN chmod 777 -R .

RUN a2enmod rewrite

COPY .env.local /var/www/html/.env
