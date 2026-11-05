#!/bin/sh
set -e

# Render indica en qué puerto debe escuchar la app
PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Solo crea o actualiza tablas. Los datos de ejemplo NO se cargan aquí:
# se cargan una sola vez desde una computadora (ver instrucciones del equipo).
php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
