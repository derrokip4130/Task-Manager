#!/bin/sh

echo "Waiting for the database to be ready..."

# wait until PostgreSQL is ready (optional)
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  echo "Database not ready yet..."
  sleep 2
done

# run Laravel setup commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# start apache
apache2-foreground
