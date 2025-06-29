#!/bin/bash

if ! [ -d "vendor" ]; then
    echo "Installing dependencies"

    composer install
fi

if [ -e "public/storage" ]; then
    rm public/storage
fi

php artisan storage:link
chmod -R 755 storage
php artisan key:generate

if [ -e ".env" ]; then
    echo ".env file already exists"
else
    echo "Creating .env file"
    cp .env.example .env
fi

echo "Running migrations"
until mysqladmin ping -hmysql --silent; do sleep 2; done && php artisan migrate --seed

echo "Starting Laravel server"
php artisan serve --host 0.0.0.0 --port 8000
