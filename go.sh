#!/bin/bash
docker run --name mysql-ticket-equations --rm -d -v "mysql-ticket-equations:/var/lib/mysql" -e MYSQL_ROOT_PASSWORD=123       mysql-laravel
docker run --name php56-ticket-equations --rm -d -v "$PWD/src:/app"                 --link mysql-ticket-equations            php-fpm-laravel:5.6.30
docker run --name nginx-ticket-equations --rm -d -v "$PWD/src:/app:ro"              --link php56-ticket-equations:php-fpm-laravel -p 8080:80 nginx-laravel
