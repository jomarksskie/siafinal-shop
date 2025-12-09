FROM php:8.2-apache

# -------------------------
# 1) System + PHP deps
# -------------------------
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable apache rewrite
RUN a2enmod rewrite

# -------------------------
# 2) Set working dir + copy project
# -------------------------
WORKDIR /var/www/html
COPY . .

# -------------------------
# 3) Composer install
# -------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# -------------------------
# 4) Vite build (Tailwind/CSS/JS)
# -------------------------
RUN npm install && npm run build

# -------------------------
# 5) Force Apache to serve /public correctly
# (IMPORTANT FIX: use REAL PATH, no env expansion issues)
# -------------------------
RUN sed -ri -e 's!/var/www/html/public!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf

# -------------------------
# 6) Permissions (Laravel needs this)
# -------------------------
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# -------------------------
# 7) Start script
# -------------------------
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
