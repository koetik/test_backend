step 1
composer update

step 2
cp .env-example ,env

step 3
php artisan key:generate

step 4 
php artisan migrate --seed

step 5
php artisan l5-swagger:generate