#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

### Check and create if storage directory does not exist ###
if [ ! -d "/var/www/storage" ]
then
    echo "Creating folder: /var/www/storage"
    mkdir /var/www/storage
fi

### Check and create if storage framework directory does not exist ###
if [ ! -d "/var/www/storage/framework" ]
then
    echo "Creating folder: /var/www/storage/framework"
    mkdir /var/www/storage/framework
fi

### Check and create if cache directory does not exist ###
if [ ! -d "/var/www/storage/framework/cache" ]
then
    echo "Creating folder: /var/www/storage/framework/cache"
    mkdir /var/www/storage/framework/cache
fi

### Check and create if sessions directory does not exist ###
if [ ! -d "/var/www/storage/framework/sessions" ]
then
    echo "Creating folder: /var/www/storage/framework/sessions"
    mkdir /var/www/storage/framework/sessions
fi

### Check and create if views directory does not exist ###
if [ ! -d "/var/www/storage/framework/views" ]
then
    echo "Creating folder: /var/www/storage/framework/views"
    mkdir /var/www/storage/framework/views
fi

chown -R www-data:www-data /var/www/storage
chmod -R 755 /var/www/storage

cd /var/www
composer install --no-ansi --no-interaction --no-progress --optimize-autoloader

if [ $(grep -c '^APP_KEY=base64:.*$' .env) -eq 0 ]
then
    echo "Application key not set. Generating one."
    php artisan key:generate
fi

if [ "$env" != "production" ]; then
    php artisan migrate
fi

### Inicia o serviço baseado na ROLE
if [ "$env" == "production" ]; then
    echo "Caching configuration..."
    (cd /var/www && php artisan config:cache && php artisan route:cache && php artisan view:cache)
else
    echo "Clearing caches..."
    (cd /var/www && php artisan config:clear && php artisan route:clear && php artisan view:clear)
fi

if [ "$role" = "app" ]; then
    exec apache2-foreground
elif [ "$role" = "queue" ]; then
    echo "Running the queue..."
    php /var/www/artisan queue:work --verbose --tries=3 --timeout=90
elif [ "$role" = "scheduler" ]; then
    # SIMULA CRON
    while [ true ]
    do
        php /var/www/artisan schedule:run --verbose --no-interaction &
        sleep 60
    done
else
    echo "Could not match the container role \"$role\""
    exit 1
fi
