#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

if [[ "${ALLOW_DB_DESTRUCTIVE:-0}" == "1" ]]; then
  echo "Warning: ALLOW_DB_DESTRUCTIVE=1 is enabled for this shell."
fi

echo "Step 1/3: database backup"
"$ROOT_DIR/scripts/db-backup.sh"

echo "Step 2/3: migration status"
docker compose exec -w /var/www/html app php artisan migrate:status

echo "Step 3/3: run safe migrate"
docker compose exec -w /var/www/html app php artisan migrate --force

echo "Done."
