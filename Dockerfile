FROM php:8.2-apache

# system + php deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# enable apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# vite build
RUN npm install && npm run build

# apache should serve /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
RUN chmod -R 775 storage bootstrap/cache
CMD ["/start.sh"]
