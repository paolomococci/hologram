# `remark`

## check if i need to update the system

If necessary upgrade the development environment and tools:

```bash
apt update && apt upgrade -y
composer --version
composer self-update
npm -v
npm view npm version
node -v
npm view node version
npm cache clean -f && npm install -g n && n stable && npm install -g npm@latest
```

## application scaffolding

```bash
cd /var/www/html/
composer create-project laravel/laravel remark
cd remark/
```

### setup of document root

```bash
sed -i "s/landing/remark/g" /etc/apache2/sites-available/default-ssl.conf
cat /etc/apache2/sites-available/default-ssl.conf | grep remark
sed -i "s/landing/remark/g" /etc/apache2/sites-available/000-default.conf
cat /etc/apache2/sites-available/000-default.conf | grep remark
apachectl --help
apachectl restart
```

## install and setup of Jetstream

Considering I'm in the root directory of the project:

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --teams --dark
npm install
npm run build
php artisan migrate:status
```

### to improve the development of `Livewire` components

```bash
composer require wire-elements/wire-spy --dev
```

### fix coding stile with `pint`

```bash
./vendor/bin/pint --help
./vendor/bin/pint --test
./vendor/bin/pint
```

### solution of `failed to open stream: permission denied`

```bash
stat -c %a bootstrap/cache
find bootstrap/cache -printf '%m %p \n'
find storage -printf '%m %p \n'
find database -printf '%m %p \n'
chmod --recursive 775 bootstrap/cache && chmod --recursive 775 storage && chmod --recursive 775 database
chown --recursive --verbose 0:33 .
```

## install Pest

```bash
composer require --dev pestphp/pest
./vendor/bin/pest --init
composer require --dev pestphp/pest-plugin-laravel
```

### migrate all tests from PHPUnit to Pest

```bash
composer require --dev pestphp/pest-plugin-drift
./vendor/bin/pest --help
./vendor/bin/pest --drift
```

### run all the tests

Please, pay attention, to verify the validity of the texts with the `--coverage` option, it is necessary to have appropriately modified the `php.ini` file with, for example, a line similar to the following:

```ini
xdebug.mode=develop,debug,trace,coverage
```

Or, better:

```bash
cat /opt/php/8.3.13/lib/php.ini | grep "xdebug.mode=develop,debug,trace"
sed -i "s/xdebug.mode=develop,debug,trace/xdebug.mode=develop,debug,trace,coverage/g" /opt/php/8.3.13/lib/php.ini
cat /opt/php/8.3.13/lib/php.ini | grep "xdebug.mode=develop,debug,trace"
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

test('welcome feature test status is ok', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
```

```bash
php artisan test --filter WelcomeFeatureTest
```

## update dependencies to the latest version

```bash
composer update --help
composer update --ignore-platform-reqs
```

## only if it is necessary to reset the entire database

```bash
php artisan db:wipe
php artisan migrate:fresh
php artisan migrate:status
php artisan db:seed
```

### only if I need to go back to the previous migration

```bash
php artisan migrate:rollback
```

## I have to remember to issue the following commands when I add a new route and it is not listed:

```bash
npm run build
chmod --recursive 775 bootstrap/cache
chmod --recursive 775 storage
chmod --recursive 775 database
chown --recursive --verbose 0:33 .
php artisan route:cache && php artisan route:clear && php artisan route:list
```

and, if I am examining the presence of a specific route, the following command has been useful to me:

```bash
php artisan route:list | grep "help"
```

## to get inspired to write custom commands

```bash
php artisan inspire
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
