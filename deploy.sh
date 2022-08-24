composer install --optimize-autoloader --no-dev

# limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# cache config
php artisan config:cache
php artisan view:cache
php artisan route:cache

