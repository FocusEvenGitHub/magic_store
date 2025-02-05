FROM php:7.4-apache
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip
COPY . /var/www/html/
RUN a2enmod rewrite
CMD ["apache2-foreground"]
