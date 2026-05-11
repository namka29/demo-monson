#!/usr/bin/env bash
# Prepend Docker Desktop CLI paths (macOS) to PATH.
# Usage:  source "/path/to/scripts/lib/docker-desktop-path.sh" && docker_desktop_prepend_path
# Or from project root:  source scripts/lib/docker-desktop-path.sh && docker_desktop_prepend_path

docker_desktop_prepend_path() {
  local d
  for d in \
    "/Applications/Docker.app/Contents/Resources/bin" \
    "${HOME}/.docker/bin" \
    "${HOME}/.orbstack/bin" \
    "/usr/local/bin" \
    "/opt/homebrew/bin"
  do
    if [[ -x "${d}/docker" ]] && [[ ":${PATH}:" != *":${d}:"* ]]; then
      PATH="${d}:${PATH}"
    fi
  done
  export PATH
}
