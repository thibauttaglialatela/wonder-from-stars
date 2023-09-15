#!/usr/bin/bash

rm -Rf vendor/
composer install --no-dev --optimize-autoloader
#installation des dépendances npm
npm install
composer dump-env prod
php bin/console doctrine:schema:create
php bin/console doctrine:migrations:migrate
php bin/console cache:clear
php bin/console cache:warmup
npm run build
