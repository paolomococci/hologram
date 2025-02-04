# scaffolding

```bash
cd /var/www/html/
composer create-project laravel/laravel chirps
cd chirps/
php artisan migrate:status
chown --recursive developer_username:apache .
chmod --recursive 775 bootstrap/cache && chmod --recursive 775 storage && chmod --recursive 775 database
```
