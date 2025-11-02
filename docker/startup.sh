#!/bin/bash

if [ ! -f "/var/www/.env" ]; then
    cp /var/www/.env.example /var/www/.env
    php artisan key:generate --force
fi

php artisan config:clear
php artisan cache:clear

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

