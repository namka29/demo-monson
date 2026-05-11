#!/usr/bin/env bash
# Chạy npm trong container Node (không cần Node/npm trên máy host).
# Không gọi `docker compose exec app npm …` — image app là PHP-FPM, không có npm.
#
# Dùng từ thư mục gốc dự án:
#   ./scripts/docker-npm.sh install
#   ./scripts/docker-npm.sh run build
#   ./scripts/docker-npm.sh ci
#
# Dev server (HMR): dùng ./scripts/docker-npm-dev.sh — cần publish port 5173.
set -euo pipefail
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."
# shellcheck source=lib/docker-desktop-path.sh
source "$SCRIPT_DIR/lib/docker-desktop-path.sh"
docker_desktop_prepend_path

exec docker compose --profile node run --rm --no-deps node npm "$@"
