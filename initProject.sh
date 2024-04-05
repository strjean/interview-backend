#!/bin/bash

if [ ! -d "app/Classes" ]; then
    mkdir -p app/Classes
fi

if [ ! -d "storage/framework/cache/data" ]; then
    mkdir -p storage/framework/cache/data
fi

echo "Please enter your GitHub OAuth authentication token: :"
read github_token
php composer.phar config github-oauth.github.com "$github_token"

composer install