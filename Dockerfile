# ✅ 1. Base image first
FROM php:8.2-apache

# ✅ 2. Install dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libonig-dev libzip-dev curl libpng-dev libpq-dev \
    && docker-php-ext-install pdo_pgsql zip mbstring exif pcntl bcmath gd

# ✅ 3. Enable Apache rewrite
RUN a2enmod rewrite

# ✅ 4. Set working directory
WORKDIR /var/www/html

# ✅ 5. Copy Laravel app
COPY . /var/www/html

# ✅ 6. Copy Composer from base image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ✅ 7. Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# ✅ 8. Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ✅ 9. Set Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# ✅ 10. Copy and enable start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

RUN which pg_isready || echo "pg_isready NOT FOUND"

# ✅ 11. Use start.sh as container entrypoint
CMD ["/start.sh"]
