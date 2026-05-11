#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."

echo "Requires MariaDB/MySQL running (match DB_* in .env). Example: docker compose up -d mariadb"
echo "For full Docker (nginx + php + MariaDB): ./scripts/docker-setup.sh"
echo "==> Composer install"
composer install --no-interaction

if [[ ! -f .env ]]; then
  echo "==> Copy .env from .env.example"
  cp .env.example .env
  php artisan key:generate --no-interaction
fi

echo "==> Migrate database (default Laravel tables; Filament expects users, etc.)"
php artisan migrate --no-interaction --force

echo "==> Filament panel scaffolding (default panel URL is usually /admin)"
php artisan filament:install --panels --no-interaction

echo "==> Front-end assets"
npm install
npm run build

echo "Done. Run: php artisan serve  (Filament panel after install: /admin)"
