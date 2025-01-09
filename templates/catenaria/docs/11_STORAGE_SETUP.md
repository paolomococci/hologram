# storage setup

## just as an example to fix error 403 caused by directory `storage`

After having appropriately edited the file `config/filesystem.php`

```php
    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('article_images') => storage_path('app/public/article_images'),
    ],
```

I should send the following commands:

```bash
php artisan storage --help
php artisan storage:link --help
php artisan storage:unlink --help
```

Create the symbolic links configured for the application:

```bash
php artisan storage:link
```

Create the symbolic link using relative paths:

```bash
php artisan storage:link --relative
```
