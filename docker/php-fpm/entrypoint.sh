#!/usr/bin/env bash

declare -A ENVS

import_env() {
    for col in $(egrep -v '^#' .env); do
        key=$(echo ${col} | cut -d'=' -f 1)
        value=$(echo ${col} | cut -d'=' -f 2)
        ENVS[${key}]=${value}
    done
}

if_not_prod_exec() {
    command=$1
    if [[ ${ENVS[APP_ENV]} != "prod" ]]; then
        ${command}
    fi
}

if_prod_exec() {
    command=$1
    if [[ ${ENVS[APP_ENV]} = "prod" ]]; then
        ${command}
    fi
}

import_env

# initialize composer package
if_not_prod_exec "composer install --no-interaction"
if_prod_exec "composer install --no-interaction --no-dev"
composer clearcache -vvv
if_prod_exec "composer dump-autoload -o -a --apcu"

# artisan initialize app
php artisan cache:clear
php artisan clear-compiled
php artisan config:clear

# set permissions
if_prod_exec "chown www-data:www-data -R ./storage ./vendor"
if_prod_exec "find ./storage -type d -exec chmod 755 {} \;"
if_prod_exec "find ./storage -type f -exec chmod 644 {} \;"
if_prod_exec "find ./vendor -type d -exec chmod 755 {} \;"
if_prod_exec "find ./vendor -type f -exec chmod 644 {} \;"

docker-php-entrypoint php-fpm
