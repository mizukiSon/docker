FROM php:8.2-cli

# Устанавливаем расширения
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Копируем файлы
COPY web/ /var/www/html/

# Создаем директории
RUN mkdir -p /var/www/html/uploads /var/www/html/images && \
    chmod 777 /var/www/html/uploads /var/www/html/images

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Создаем тестовый файл для проверки
RUN echo "<?php phpinfo(); ?>" > info.php && \
    echo "<?php echo 'Railway PHP is working!'; ?>" > test.php

# Экспонируем порт
EXPOSE 8080

# Запускаем PHP сервер на порту 8080
CMD php -S 0.0.0.0:8080 -t /var/www/html