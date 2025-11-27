# frontend

## inside the app container

```shell
podman exec -it --privileged lamp-feather-app bash
cd /var/www/html/feather/
```

To make the Tailwind classes and AlpineJS code regenerate, it is recommended to add the following line to the `scripts` section of the `package.json` file:

```json
        "build:watch": "vite build --watch"
```

Then issue the following command from the project root directory:

```shell
npm run build:watch
```

Now I create controllers and components:

```shell
php artisan make:livewire --help
php artisan make:livewire --verbose --pest task
php artisan make:livewire --verbose --pest search
php artisan make:livewire --verbose --pest header
```

### three ways to create components that can load icons

Example of a pure and simple Blade component:

```shell
php artisan make:component --verbose --view --pest glyph
```

When needed, it will be recalled, for example, in the following way:

```php
<x-glyph name="icon_name" title="visual_tooltip" />
```

Example of a class used to load icons by creating an instance with the Laravel service container:

```shell
php artisan make:class --help
php artisan make:class --verbose --invokable Lithos
```

When needed it will be recalled as follows:

```php
{!! app(\App\Lithos::class)('icon_name', 'h-6 w-6 text-red-500', 'descriptive_text_label', 'visual_tooltip') !!}
```

Example of helper class, `helpers/IconHelper.php`, created manually, in this case it is necessary to edit `composer.json` to the section `psr-4` which takes care of autoload:

```json
...
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "Helpers\\": "helpers/"
        }
    },
...
```

And type:

```shell
composer dump-autoload
```

When needed it will be recalled as follows:

```php
{!! \Helpers\IconHelper::inlineIcon('icon_name', 'h-6 w-6 text-blue-500', 'descriptive_text_label', 'visual_tooltip') !!}
```

__Remember to replace placeholders, `icon_name`, `descriptive_text_label` and `visual_tooltip` with the correct terms.__

## create a new layout in which to insert the main views of the application

Make layout:

```shell
php artisan livewire:layout --verbose
```

After editing the layout:

```shell
npm run build
```

## useful commands

If you encounter any problems you can try the following commands:

```shell
cd /var/www/html/feather/
chown www-data:www-data -R .
chmod -R 777 .
```

or:

```shell
chown -R www-data:www-data storage bootstrap/cache
```

## show tasks and results

To create some views:

```shell
php artisan livewire:make --help
php artisan livewire:make --verbose ShowTask
php artisan livewire:make --verbose SearchResults
```
