#!/bin/sh
set -e

# The ./apps/api bind mount shadows the chown done at image build time, so the
# host files stay owned by the host user and php-fpm (www-data) cannot write to
# them. PHP 8.5 surfaces this as:
#   tempnam(): file created in the system's temporary directory
# Fix ownership here, before dropping privileges, so it self-heals on every up.
if [ -d storage ]; then
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
fi

exec docker-php-entrypoint "$@"
