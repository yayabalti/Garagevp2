#!/bin/sh
set -e

# Correction des permissions des certificats SSL
if [ -d /etc/ssl/private/ ]; then
    chmod 644 /etc/ssl/private/*.crt
    chmod 600 /etc/ssl/private/*.key
fi

# Démarrage de nginx en premier plan
exec nginx -g 'daemon off;'