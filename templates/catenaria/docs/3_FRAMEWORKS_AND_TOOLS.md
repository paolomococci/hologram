# frameworks and tools

Now I continue by adding more features to this application:

```bash
composer show | grep "livewire"
composer require livewire/livewire
npm install
npm run build
```

## to improve the development of `Livewire` components

```bash
composer require wire-elements/wire-spy --dev
```

### fix coding stile with `pint`

```bash
./vendor/bin/pint --help
./vendor/bin/pint --test
./vendor/bin/pint
```

## install Pest

```bash
composer require --dev --with-all-dependencies pestphp/pest
./vendor/bin/pest --init
composer require --dev pestphp/pest-plugin-laravel
```

### migrate all tests from PHPUnit to Pest

```bash
composer require --dev pestphp/pest-plugin-drift
./vendor/bin/pest --drift
```

### run all the tests

Please, pay attention, to verify the validity of the texts with the `--coverage` option, it is necessary to have appropriately modified the `php.ini` file with, for example, a line similar to the following:

```ini
xdebug.mode=develop,debug,trace,coverage
```

```bash
php artisan test --coverage
```

## how to check installed packages

```bash
composer show --help
composer show
composer show --tree
composer show | grep laravel
composer show | grep pest
```

## how to check licenses of installed packages

```bash
composer require --dev dominikb/composer-license-checker
./vendor/bin/composer-license-checker help
./vendor/bin/composer-license-checker list
./vendor/bin/composer-license-checker check
./vendor/bin/composer-license-checker report
```

## commands that may prove useful

```bash
composer suggest --all
```

To diagnose any problems:

```bash
composer --help diagnose
composer diagnose
```

## how to create a new testing class with Pest

```bash
php artisan make:test --help
```

### `web` routes example test

```bash
php artisan make:test --pest WelcomeFeatureTest
```

```php
<?php

test('welcome feature test', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
```

```bash
php artisan test --filter WelcomeFeatureTest
```

## a library for generate SVG charts

```bash
composer require maantje/charts
```

## libraries for processing typical office documents

Documents such as spreadsheets, text documents, and documents suitable for printing:

```bash
composer require tecnickcom/tc-lib-pdf
composer require phpoffice/phpspreadsheet
composer require phpoffice/phpword
```

## QR Code

```bash
composer require endroid/qr-code
```

## non-blocking concurrency framework

```bash
composer require amphp/amp
```

## static analysis tool

```bash
composer require --dev phpstan/phpstan
```

And use:

```bash
./vendor/bin/phpstan analyse src tests
```

Finally, a further check on the licenses of the packages installed in the web application:

```bash
./vendor/bin/composer-license-checker report
```
