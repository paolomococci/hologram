# CORS setup

```bash
php artisan install:api
php artisan config:publish cors
```

Add the following settings to the file `.env` as follows:

```text
...
APP_URL=https://chirps-hologram-srv.local
...
SESSION_DOMAIN=https://chirps-hologram-srv.local
...
```

--- TODO ---

```php
...
        env('CORS_ALLOW_ORIGINS'),
...
```
