# setup authentication

## install `Fortify`

```bash
composer require laravel/fortify
php artisan fortify:install
php artisan migrate:status
php artisan migrate --pretend
php artisan migrate
./vendor/bin/composer-license-checker report
```

## Laravel `sanctum`

```bash
php artisan install:api
```
