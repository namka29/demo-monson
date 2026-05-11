#!/bin/sh
set -eu

umask 022
mkdir -p \
  storage/framework/sessions \
  storage/framework/views \
  storage/framework/cache/data \
  storage/logs \
  bootstrap/cache

cd /var/www/html

if command -v chown >/dev/null 2>&1; then
  chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
fi

if [ ! -f vendor/autoload.php ] && command -v composer >/dev/null 2>&1; then
  echo "[entrypoint] vendor/ missing; running composer install…"
  composer install --no-interaction --prefer-dist ${COMPOSER_FLAGS:-}
fi

if [ -f vendor/autoload.php ] && [ -f artisan ] && [ -f .env ]; then
  if ! grep -qE '^APP_KEY=base64:[A-Za-z0-9+/=]+' .env 2>/dev/null; then
    echo "[entrypoint] APP_KEY missing — generating application key…"
    php artisan key:generate --force --no-interaction
  fi
fi

exec docker-php-entrypoint "$@"
