#!/usr/bin/env bash
set -euo pipefail

if [ -f artisan ]; then
  php artisan migrate --force || true
fi

exec "$@"
