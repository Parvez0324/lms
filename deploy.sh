#!/bin/bash
set -e

echo "🚀 Starting KAN LMS Live Server Deployment..."

# 1. Pull the latest code from GitHub
echo "📥 Pulling latest changes from GitHub (main)..."
git pull origin main

# 2. Install/Update Composer dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 3. Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 4. Clear and rebuild application caches
echo "⚡ Optimizing Laravel configuration and caches..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Live Server Deployment Completed Successfully!"
