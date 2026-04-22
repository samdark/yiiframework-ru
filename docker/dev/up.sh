#!/bin/sh

set -eu

if [ -z "${DOCKER_COMPOSE_DEV:-}" ]; then
    echo 'DOCKER_COMPOSE_DEV is not set.' >&2
    exit 1
fi

if sh -c "$DOCKER_COMPOSE_DEV up -d --wait --wait-timeout 60 --remove-orphans"; then
    port="$(sh -c "$DOCKER_COMPOSE_DEV port app 80")"
    host_port="${port##*:}"
    url="http://localhost$( [ "$host_port" = '80' ] || printf ':%s' "$host_port" )"
    printf '🚀 Started server at %s\n' "$url"
    exit 0
fi

echo '❌ Failed to start server.' >&2
container_id="$(sh -c "$DOCKER_COMPOSE_DEV ps -a -q app 2>/dev/null" || true)"

if [ -n "$container_id" ]; then
    state="$(docker inspect -f '{{.State.Status}}' "$container_id" 2>/dev/null || true)"
    health="$(docker inspect -f '{{if .State.Health}}{{.State.Health.Status}}{{end}}' "$container_id" 2>/dev/null || true)"
    exit_code="$(docker inspect -f '{{.State.ExitCode}}' "$container_id" 2>/dev/null || true)"
    error="$(docker inspect -f '{{.State.Error}}' "$container_id" 2>/dev/null || true)"

    [ -n "$health" ] && echo "Container health: $health" >&2
    [ -n "$state" ] && echo "Container state: $state" >&2
    [ -n "$exit_code" ] && echo "Container exit code: $exit_code" >&2
    [ -n "$error" ] && echo "Container error: $error" >&2

    echo 'Recent logs:' >&2
    sh -c "$DOCKER_COMPOSE_DEV logs --tail=50 app" >&2 || true
fi

exit 1
