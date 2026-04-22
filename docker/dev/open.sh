#!/bin/sh

set -eu

if [ -z "${DOCKER_COMPOSE_DEV:-}" ]; then
    echo 'DOCKER_COMPOSE_DEV is not set.' >&2
    exit 1
fi

port="$(sh -c "$DOCKER_COMPOSE_DEV port app 80 2>/dev/null" || true)"

if [ -z "$port" ]; then
    echo "Start server with 'make up' first." >&2
    exit 0
fi

host_port="${port##*:}"
url="http://localhost$( [ "$host_port" = '80' ] || printf ':%s' "$host_port" )"
opener="$(command -v xdg-open || command -v open || command -v wslview || true)"

if [ -z "$opener" ]; then
    echo "❌ Could not open $url." >&2
    exit 0
fi

"$opener" "$url" >/dev/null 2>&1 &
