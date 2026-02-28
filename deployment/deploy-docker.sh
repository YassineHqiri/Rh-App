#!/usr/bin/env bash
set -euo pipefail

echo "[deploy-docker] Starting deployment..."
cd "$(dirname "$0")/.."

if [ ! -f .env ]; then
  echo "[deploy-docker] .env file not found. Aborting."
  exit 1
fi

echo "[deploy-docker] Building and starting containers..."
docker compose -f docker-compose.prod.yml up -d --build --remove-orphans

echo "[deploy-docker] Running Laravel migrations..."
docker compose -f docker-compose.prod.yml exec -T app php artisan migrate --force

echo "[deploy-docker] Refreshing Laravel caches..."
docker compose -f docker-compose.prod.yml exec -T app php artisan optimize:clear
docker compose -f docker-compose.prod.yml exec -T app php artisan config:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan route:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan view:cache

echo "[deploy-docker] Deployment finished successfully."
