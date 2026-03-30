FROM php:8.2-cli

# Устанавливаем расширения
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Копируем файлы
COPY web/ /var/www/html/

# Создаем директорию для uploads
RUN mkdir -p /var/www/html/uploads && \
    chmod 777 /var/www/html/uploads

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Открываем порт
EXPOSE 8000

# Запускаем PHP встроенный сервер с правильным хостом
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]