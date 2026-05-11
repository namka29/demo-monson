#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

BACKUP_DIR="${BACKUP_DIR:-storage/backups}"
mkdir -p "$BACKUP_DIR"

STAMP="$(date +%Y%m%d_%H%M%S)"
OUTPUT_FILE="$BACKUP_DIR/db_${STAMP}.sql"

echo "Creating database backup: $OUTPUT_FILE"
docker compose exec -T mysql sh -lc 'exec mysqldump --single-transaction --quick --set-gtid-purged=OFF --no-tablespaces -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' > "$OUTPUT_FILE"

echo "Backup completed: $OUTPUT_FILE"
