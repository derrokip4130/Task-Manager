#!/bin/bash

echo "Waiting for PostgreSQL via Laravel..."

until php artisan migrate:status > /dev/null 2>&1; do
  echo "Database is not ready yet..."
  sleep 3
done

echo "Database is up. Running Laravel setup..."

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Start Apache
apache2-foreground
