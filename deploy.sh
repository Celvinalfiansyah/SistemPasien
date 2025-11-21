#!/bin/bash

echo "🚀 Starting Laravel deployment..."

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Run database migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force

# Cache optimization
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment completed!"