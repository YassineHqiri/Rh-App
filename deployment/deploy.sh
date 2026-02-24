#!/usr/bin/env bash
set -euo pipefail

echo "[deploy] Starting deployment..."

# Ensure we are in app root
cd "$(dirname "$0")/.."

echo "[deploy] Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

if command -v npm >/dev/null 2>&1; then
  echo "[deploy] Installing/building frontend assets..."
  npm ci
  npm run production
else
  echo "[deploy] npm not found; skipping frontend build."
fi

echo "[deploy] Running database migrations..."
php artisan migrate --force

echo "[deploy] Caching Laravel config/routes/views..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[deploy] Restarting queues/opcache if available..."
php artisan queue:restart || true

echo "[deploy] Deployment finished successfully."
