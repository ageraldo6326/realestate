git pull origin main
composer install --no-dev --optimize-autoloader

npm ci
npm run build

php artisan migrate

php artisan optimize:clear
php artisan optimize

php artisan storage:link

php artisan queue:restart
