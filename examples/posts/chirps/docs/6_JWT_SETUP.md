# setup of JWT capability

```bash
composer require php-open-source-saver/jwt-auth
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

Note:

`Copying file [vendor/php-open-source-saver/jwt-auth/config/config.php] to [config/jwt.php]`

Now I generate a secret key to handle the token encryption:

```bash
php artisan jwt:secret
```

Note:

`jwt-auth secret [...] set successfully.`

## configuration of `config/auth.php`

```php
...
    'defaults' => [
        // 'guard' => env('AUTH_GUARD', 'web'),
        'guard' => 'api',
        // 'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
        'passwords' => 'users'
    ],
...
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],
...
```

## edit `app/Models/User.php`

```php
...
class User extends Authenticatable implements JWTSubject
...
```

## make `AuthController`

```bash
php artisan make:controller AuthController
php artisan make:controller Rest/AuthRestController
```

Note:

`Controller [app/Http/Controllers/AuthController.php] created successfully.`

and edit like this:

```php

```

## make middleware `CheckTokenVersion`

```bash
php artisan make:middleware CheckTokenVersion
```

Note:

`Middleware [app/Http/Middleware/CheckTokenVersion.php] created successfully.`

## make `token` migration

```bash
php artisan make:migration add_token_version_to_users_table
```

Note:

`Migration [database/migrations/2025_02_01_040352_add_token_version_to_user_table.php] created successfully.`

## add API routes

```bash
cd routes
touch api.php
```

Edit the `api.php` file accordingly to list all the routes of interest.

And add a line to file `bootstrap/app.php` like the following example:

```php
...
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php', // add this line!
        health: '/up',
...
```

Then you need to check the routes with the following command:

```bash
php artisan route:list
```
