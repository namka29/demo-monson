#!/usr/bin/env bash
# Build Vite (public/build) qua Docker (app hoặc service node)
set -euo pipefail
cd "$(dirname "$0")"
exec ./scripts/docker-npm.sh run build
