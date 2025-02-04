# setup of JWT capability

```bash
composer require php-open-source-saver/jwt-auth
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

Now I generate a secret key to handle the token encryption:

```bash
php artisan jwt:secret
```

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
```

## make middleware `CheckTokenVersion`

```bash
php artisan make:middleware CheckTokenVersion
```

## make `token` migration

```bash
php artisan make:migration add_token_version_to_users_table
```

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

Getting something similar to the following:

```bash
  GET|HEAD  / ........................................................................................................................................................ 
  POST      api/login ........................................................................................................................... AuthController@login
  POST      api/logout ......................................................................................................................... AuthController@logout
  POST      api/post ........................................................................................................................... PostsController@store
  GET|HEAD  api/post/{id} ....................................................................................................................... PostsController@show
  PUT       api/post/{id} ..................................................................................................................... PostsController@update
  DELETE    api/post/{id} .................................................................................................................... PostsController@destroy
  GET|HEAD  api/posts .......................................................................................................................... PostsController@index
  POST      api/refresh ....................................................................................................................... AuthController@refresh
  POST      api/register ..................................................................................................................... AuthController@register
  GET|HEAD  storage/{path} ............................................................................................................................. storage.local
  GET|HEAD  up ....................................................................................................................................................... 
```
