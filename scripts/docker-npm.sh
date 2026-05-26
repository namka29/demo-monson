#!/usr/bin/env bash
# Chạy npm trong Docker (không cần Node/npm trên máy host).
# Ưu tiên container `app` (PHP + Node 22); nếu stack chưa chạy thì dùng service `node`.
#
# Dùng từ thư mục gốc dự án:
#   ./scripts/docker-npm.sh install
#   ./scripts/docker-npm.sh run build
#   ./scripts/docker-npm.sh ci
#
# Trực tiếp (khi app đang up): docker compose exec -w /var/www/html app npm run build
# Dev server (HMR): ./scripts/docker-npm-dev.sh — publish port 5173 qua service `node`
set -euo pipefail
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."
# shellcheck source=lib/docker-desktop-path.sh
source "$SCRIPT_DIR/lib/docker-desktop-path.sh"
docker_desktop_prepend_path

if docker compose ps --status running --services app 2>/dev/null | grep -qxF app; then
  exec docker compose exec -w /var/www/html -T app npm "$@"
fi

exec docker compose --profile node run --rm --no-deps node npm "$@"
