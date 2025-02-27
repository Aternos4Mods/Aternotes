FROM php:8.4-fpm

RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd mysqli pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html/
RUN chown -R www-data:www-data /var/www/html/storage/framework
RUN chmod -R 755 /var/www/html/
RUN chmod -R 755 /var/www/html/storage/framework

RUN composer install --no-dev --no-interaction --prefer-dist

EXPOSE 9000
