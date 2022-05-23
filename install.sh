#!/bin/bash

read -p "Full Install?" yn
	case $yn in
			[Yy]* )
			cp .env.example .env;
			mkdir -p storage/framework/{sessions,views,cache};
			composer install;
			php artisan key:generate;
			php artisan jwt:secret;
			php artisan migrate --seed;
			exit 0
			;;
	esac


read -p "copy .env file?" yn
    case $yn in
        [Yy]* ) cp .env.prod .env;;
    esac

read -p "Create storage directories?" yn
    case $yn in
        [Yy]* ) mkdir -p storage/framework/{sessions,views,cache};;
    esac

read -p "elevate storage folder permissions?" yn
    case $yn in
        [Yy]* ) chmod -R 777 storage/;;
    esac


read -p "Composer install?" yn
    case $yn in
        [Yy]* ) composer install;;
    esac

read -p "php artisan key:generate?" yn
    case $yn in
        [Yy]* ) php artisan key:generate;;
    esac

read -p "php artisan jwt:secret?" yn
    case $yn in
        [Yy]* ) php artisan jwt:secret;;
    esac

read -p "Migrate DB?" yn
    case $yn in
        [Yy]* ) php artisan migrate;;
    esac
