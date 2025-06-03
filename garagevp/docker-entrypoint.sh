#!/bin/sh
set -e

# Vider le cache en tant que www-data
php bin/console cache:clear --env=dev

# Garder le conteneur en vie
exec "$@"