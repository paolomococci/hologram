# `components` (Material Design)

## setup of dev environment

I want to create components that are as reusable as possible, always with a mobile first perspective.

I start by creating a layout dedicated to the development of reusable components named `material.blade.php`.

Now I create a component Livewire for component development:

```bash
php artisan make:livewire Material/workbench
```

I modify the file accordingly `routes/web.php`:

```php
use App\Livewire\Material\Workbench as MaterialDesignWorkbench;
Route::get('/material', MaterialDesignWorkbench::class)->name('material');
```

and I issue the following command to regenerate the route cache and get immediate feedback:

```bash
php artisan route:clear && php artisan route:cache && php artisan route:list | grep "material"
```

## accordions

### `<x-accordions.simply-toggle jsonDataItems="{{ $jsonDataItems }}" />` alias tag

```bash
php artisan make:component accordions.simply-toggle --view
```

![accordions.simply-toggle](./screenshots/components/screenshot_x-accordions.simply-toggle_thesis.png)

### `<x-accordions.icon-toggle jsonDataItems="{{ $jsonDataItems }}" />` alias tag

```bash
php artisan make:component accordions.icon-toggle --view
```

![accordions.simply-toggle](./screenshots/components/screenshot_x-accordions.icon-toggle_thesis.png)

## alerts

```bash
php artisan make:component alerts.offline --view
```

## login

### login anonymous component:

```bash
php artisan make:component login.simply --view
```

or:

```bash
php artisan make:component login.login-anonymous --view
```

![x-login.simply light](./screenshots/components/screenshot_x-login_simply_light.png)

![x-login.simply dark](./screenshots/components/screenshot_x-login_simply_dark.png)

### login component with class:

```bash
php artisan make:component Login/LoginComplete
```

## register

### register anonymous component:

```bash
php artisan make:component register.simply --view
```

or:

```bash
php artisan make:component register.simply-anonymous --view
```

![x-register.simply light](./screenshots/components/screenshot_x-register_simply_light.png)

![x-register.simply dark](./screenshots/components/screenshot_x-register_simply_dark.png)

### register component with class:

```bash
php artisan make:component Register/RegisterComplete
```
