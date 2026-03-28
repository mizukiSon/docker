FROM php:8.2-apache

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

# Устанавливаем GD для работы с изображениями
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd

# Включаем mod_rewrite для Apache
RUN a2enmod rewrite

# Создаем директорию для загрузок и даем права
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/uploads

COPY . /var/www/html/