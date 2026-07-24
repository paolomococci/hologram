# scaffolding

```bash
cd /var/www/html/
composer create-project laravel/laravel posts
cd posts/
php artisan install:api
php artisan migrate:status
sudo chown --recursive $(whoami):apache .
chmod --recursive 775 bootstrap/cache && chmod --recursive 775 storage && chmod --recursive 775 database
```
