FROM php:7.4-apache
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY . /var/www/html/

RUN a2enmod rewrite

# OBS: Essa abordagem executa as migrations na construção da imagem.
RUN php /var/www/html/database/magic_store.php

CMD ["apache2-foreground"]
