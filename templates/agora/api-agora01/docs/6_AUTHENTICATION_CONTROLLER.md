# authentication

```bash
php artisan make:controller AuthenticationController
```

## settings

Edit `.env` file:

```conf
...
APP_URL=https://api-agora01.hologram-srv.local
...
SESSION_DOMAIN=.hologram-srv.local
...
# Sanctum
SANCTUM_STATEFUL_DOMAINS=.hologram-srv.local
...
```
