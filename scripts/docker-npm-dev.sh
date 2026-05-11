#!/usr/bin/env bash
# Chạy `npm run dev` (Vite) trong Docker — mở http://localhost:${VITE_PORT:-5173}
# Laravel vẫn chạy trên host hoặc nginx container; @vite sẽ trỏ tới hot file khi APP_URL khớp.
set -euo pipefail
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."
# shellcheck source=lib/docker-desktop-path.sh
source "$SCRIPT_DIR/lib/docker-desktop-path.sh"
docker_desktop_prepend_path

PORT="${VITE_PORT:-5173}"
exec docker compose --profile node run --rm --no-deps \
  -p "${PORT}:${PORT}" \
  -e "VITE_PORT=${PORT}" \
  node npm run dev
