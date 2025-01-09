# install and setup icons

## Blade Carbon Icons

Install:

```bash
composer require codeat3/blade-carbon-icons
```

check on the licenses of the packages installed in the web application:

```bash
./vendor/bin/composer-license-checker report
```

setup:

```bash
php artisan vendor:publish --tag=blade-carbon-icons-config
```

and use:

```php
<x-carbon-download/>
<x-carbon-download class="text-red-600 dark:text-red-300 size-4" />
<x-carbon-download style="color: #eee" />
```

### raw SVG icons

Setup:

```bash
php artisan vendor:publish --tag=blade-carbon-icons --force
```

and use:

```php
<img src="{{ asset('./vendor/blade-carbon-icons/download.svg') }}" width="16" height="16" />
<img src="{{ asset('./vendor/blade-carbon-icons/download.svg') }}" width="24" height="24" class="size-6" />
```
