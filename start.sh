#!/bin/bash

# Ensure permissions
chown -R www-data:www-data storage bootstrap/cache

# Wait for PostgreSQL to be ready
until /usr/bin/pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  echo "Waiting for PostgreSQL at $DB_HOST:$DB_PORT..."
  sleep 2
done

# Laravel setup
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Start Apache
apache2-foreground
