sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
sudo chmod -R 777 public/publish/thumbnail
sudo chmod -R 777 public/publish/tv
#instalar dependências
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan key:generate
php artisan optimize:clear
