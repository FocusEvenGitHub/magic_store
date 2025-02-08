FROM php:7.4-apache
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY . /var/www/html/

RUN a2enmod rewrite

# Altera o DocumentRoot do Apache para /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]
