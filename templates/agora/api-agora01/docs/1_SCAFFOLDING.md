# scaffolding

```bash
cd /var/www/html/agora-project/
composer create-project laravel/laravel api-agora01
cd api-agora01/
php artisan migrate:status
sudo chown --recursive developer_username:apache .
chmod --recursive 775 bootstrap/cache && chmod --recursive 775 storage && chmod --recursive 775 database
```
