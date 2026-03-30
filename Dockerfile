FROM php:8.2-apache

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli

# Отключаем конфликтующие MPM модули и включаем нужный
RUN a2dismod mpm_event && \
    a2dismod mpm_worker && \
    a2enmod mpm_prefork && \
    a2enmod rewrite

# Копируем файлы проекта
COPY web/ /var/www/html/

# Устанавливаем права на запись для директории uploads
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod 777 /var/www/html/uploads

# Конфигурация Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Открываем порт
EXPOSE 80

# Запускаем Apache в foreground режиме
CMD ["apache2-foreground"]