#!/usr/bin/env bash
# Start the Docker stack (nginx + php-fpm + mysql), run migrations, Filament, and Vite build.
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."

# shellcheck source=lib/docker-desktop-path.sh
source "$SCRIPT_DIR/lib/docker-desktop-path.sh"
docker_desktop_prepend_path

if ! command -v docker &>/dev/null; then
  echo "❌ 'docker' not found in PATH (even after prepending common Docker Desktop locations)." >&2
  echo "" >&2
  echo "Hints:" >&2
  echo "  1) Open Docker Desktop and wait until it is Running (whale icon stable, not 'Starting…')." >&2
  echo "  2) If the terminal still has no 'docker': Docker Desktop → Settings → Advanced (or CLI tools) — enable CLI integration; or Troubleshoot → install/reset CLI per Docker docs." >&2
  echo "  3) In bash, try:  source \"$SCRIPT_DIR/lib/docker-desktop-path.sh\" && docker_desktop_prepend_path" >&2
  echo "     then:  which docker && docker compose version" >&2
  exit 127
fi

if ! docker compose version &>/dev/null; then
  echo "❌ 'docker' is present but Compose v2 ('docker compose') is missing. Update Docker Desktop." >&2
  exit 127
fi

echo "Docker / CLI OK: $(command -v docker)"
docker compose version 2>/dev/null | head -1 || true

if [[ ! -f .env ]]; then
  echo "→ Creating .env from .env.docker"
  cp .env.docker .env
fi

echo "→ Build & docker compose up"
docker compose build app
docker compose up -d

echo "→ APP_KEY (only if .env has no key yet)"
if ! grep -qE '^APP_KEY=base64:' .env; then
  docker compose exec -T app php artisan key:generate --ansi
fi

echo "→ Migrate"
docker compose exec -T app php artisan migrate --force

echo "→ Filament (safe to ignore errors if already installed)"
docker compose exec -T app php artisan filament:install --panels --no-interaction || true

echo "→ NPM build → public/build"
"$SCRIPT_DIR/docker-npm.sh" install
"$SCRIPT_DIR/docker-npm.sh" run build

PORT="${APP_PORT:-8080}"
echo "Done — open ${APP_URL:-http://localhost:$PORT} (nginx listens on port $PORT).

Useful commands:
  docker compose logs -f
  docker compose exec app php artisan tinker"
