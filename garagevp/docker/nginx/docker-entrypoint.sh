#!/bin/sh
set -e


# Démarrage de nginx en premier plan
exec nginx -g 'daemon off;'