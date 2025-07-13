#!/bin/bash

echo "Waiting for the database to be ready..."

# Try connecting via Laravel's migration status
until php artisan migrate:status > /dev/null 2>&1; do
  echo "Database not ready yet..."
  sleep 2
done

echo "Database is ready!"

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Start Apache
apache2-foreground
