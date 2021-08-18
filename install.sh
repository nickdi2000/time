#!/bin/bash
mkdir -p storage/framework/{sessions,views,cache}
composer install
php artisan key:generate
