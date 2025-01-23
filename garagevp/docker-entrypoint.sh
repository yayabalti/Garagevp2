#!/bin/sh
set -e

# Vider le cache au démarrage
php bin/console cache:clear

# Démarrer PHP-FPM
exec "$@"