#!/usr/bin/env bash
# Run any command with Docker Desktop on PATH (macOS), e.g.:
#   ./scripts/run-with-docker.sh docker compose ps
#   ./scripts/run-with-docker.sh docker compose up -d
set -euo pipefail
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
# shellcheck source=lib/docker-desktop-path.sh
source "$SCRIPT_DIR/lib/docker-desktop-path.sh"
docker_desktop_prepend_path
exec "$@"
