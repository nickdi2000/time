#!/bin/bash

	read -p "Full Install?" yn
			case $yn in
					[Yy]* )
					cp .env.example .env;
					mkdir -p storage/framework/{sessions,views,cache};
					composer install;
					php artisan key:generate;
					php artisan jwt:secret;
					exit 0
					;;
					* ) exit;;
			esac


		read -p "copy .env file?" yn
		    case $yn in
		        [Yy]* ) cp .env.example .env;;
		        * ) exit;;
		    esac

read -p "Create storage directories?" yn
    case $yn in
        [Yy]* ) mkdir -p storage/framework/{sessions,views,cache};;
        * ) exit;;
    esac


		read -p "Composer install?" yn
		    case $yn in
		        [Yy]* ) composer install;;
		        * ) exit;;
		    esac

		read -p "php artisan key:generate?" yn
		    case $yn in
		        [Yy]* ) php artisan key:generate;;
		        * ) exit;;
		    esac

		read -p "php artisan jwt:secret?" yn
		    case $yn in
		        [Yy]* ) php artisan jwt:secret;;
		        * ) exit;;
		    esac
