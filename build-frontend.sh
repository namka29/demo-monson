#!/usr/bin/env bash
# Build Vite (public/build) qua container Node — KHÔNG dùng: docker compose exec app npm …
set -euo pipefail
cd "$(dirname "$0")"
exec ./scripts/docker-npm.sh run build
