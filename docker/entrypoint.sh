#!/bin/sh

cd /var/www

php artisan migrate:fresh --seed --force
#php artisan passport:install
#php artisan db:seed
#php artisan migrate --force -q -n
#php artisan key:generate
 php artisan optimize:clear
# php artisan logs:clear
# php artisan scout:import "App\Domain\Users\Models\User"
# php artisan scout:import "App\Domain\Users\Models\UserProfile"

/usr/bin/supervisord -c /etc/supervisord.conf
