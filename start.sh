#!/bin/bash

# Ensure permissions
chown -R www-data:www-data storage bootstrap/cache

# Wait for DB to be ready (optional but helpful)
echo "Waiting for database..."
until pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USERNAME; do
  sleep 1
done

# Laravel setup
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Start Apache
apache2-foreground
