#!/usr/bin/env bash
set -e

echo "Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

echo "Running migrations..."
php artisan migrate --force

echo "Starting server..."
php artisan serve --host 0.0.0.0 --port ${PORT:-10000}
