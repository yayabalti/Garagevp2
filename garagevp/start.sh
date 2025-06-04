#!/bin/sh

# Démarrer PHP-FPM en arrière-plan
php-fpm -D

# Démarrer Nginx en premier plan (indispensable pour que Render le garde actif)
nginx -g "daemon off;"
