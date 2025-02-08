cd /var/www/html

composer update
npm install

chmod -R 777 storage
chmod -R 777 bootstrap/cache

php artisan migrate
php artisan storage:link

php artisan serve --host 0.0.0.0