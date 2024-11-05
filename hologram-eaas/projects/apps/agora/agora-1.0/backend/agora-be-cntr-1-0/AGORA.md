# `agora-be-cntr-1-0` agora

## credentials

*root system password of backend:*  some_password

## access the container with root credentials

```bash
podman exec --interactive --tty --privileged agora-be-cntr-1-0 bash
```

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
sed -i "s/landing/agora/g" /etc/apache2/sites-available/default-ssl.conf
cat /etc/apache2/sites-available/default-ssl.conf | grep agora
sed -i "s/landing/agora/g" /etc/apache2/sites-available/000-default.conf
cat /etc/apache2/sites-available/000-default.conf | grep agora
apachectl --help
apachectl restart
composer list
ls -l
composer create-project laravel/laravel agora
cat /etc/passwd | grep 'root'
cat /etc/passwd | grep 'www-data'
chown --recursive --verbose 0:33 agora/
cd agora
composer suggest --all
php artisan migrate:status
ls -l
stat -c %a bootstrap/cache
find bootstrap/cache -printf '%m %p \n'
find storage -printf '%m %p \n'
find database -printf '%m %p \n'
chmod --recursive 775 bootstrap/cache
chmod --recursive 775 storage
chmod --recursive 775 database
php artisan cache:clear
```

## setup of Jetstream

Considering I'm in the root directory of the project:

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --teams --dark
npm install
npm run build
php artisan migrate:status
chown --recursive --verbose 0:33 .
php artisan cache:clear
```

## commands that may prove useful

To diagnose any problems:

```bash
composer --help diagnose
composer diagnose
```

## stop and start the system

```bash
exit
podman stop agora-be-cntr-1-0
podman start agora-be-cntr-1-0
podman exec --interactive --tty --privileged agora-be-cntr-1-0 bash
```

## database application setup

Edit `.env`

```text
APP_NAME=agora
APP_ENV=local
...

...
APP_URL=https://192.168.1.XXX:8443/

AGORA_DB_CNTR_CONNECTION=agora-db-dev-user-1-0
AGORA_DB_CNTR_HOST=192.168.1.XXX
AGORA_DB_CNTR_PORT=3306
AGORA_DB_CNTR_DATABASE=agora-db-1-0
AGORA_DB_CNTR_USERNAME=agora-db-dev-user-1-0
AGORA_DB_CNTR_PASSWORD=some_password
...
```

Edit the `config/database.php` configuration file:

```php
        'agora-db-cntr-1-0' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('AGORA_DB_CNTR_HOST', '127.0.0.1'),
            'port' => env('AGORA_DB_CNTR_PORT', '3306'),
            'database' => env('AGORA_DB_CNTR_DATABASE', 'laravel'),
            'username' => env('AGORA_DB_CNTR_USERNAME', 'root'),
            'password' => env('AGORA_DB_CNTR_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
```

Edit the `config/jetstream.php` configuration file:

```php
    'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        Features::api(),
        Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],
```

### add appropriate models for application

Considering I'm in the root directory of the project:

```bash
php artisan make:model --all Author
php artisan make:model --all Article
php artisan make:model --pivot --migration Contributor
chown --recursive --verbose root:www-data .
```

Appropriately modify the files relating to the models and the files relating to the migrations, including the reference to the correct database:

```php
    protected $connection = 'agora-db-cntr-1-0';
```

### I added SanitizerUtil class

```bash
php artisan make:class Utils/SanitizerUtil
```

### I take care of the migrations on the RDBMS

```bash
php artisan schema:dump
php artisan migrate:status
php artisan migrate --pretend
chown --recursive --verbose root:www-data .
php artisan migrate
php artisan migrate:status
php artisan migrate:rollback
php artisan list
php artisan model:show Author
php artisan model:show Article
php artisan model:show Contributor
php artisan migrate --pretend
php artisan migrate
php artisan model:show Author
php artisan model:show Article
php artisan model:show Contributor
php artisan make:factory ContributorFactory
php artisan make:seeder ContributorSeeder
php artisan migrate:fresh
php artisan db:seed --class=DatabaseSeeder --verbose
```

### example of repeat migration

```bash
php artisan migrate --path=./database/migrations/time_create_name_table.php
```

Naturally, in addition to issuing the previous commands by positioning yourself in the project root, the file names will be different in the part referring to the date.

## useful notes for solving small problems

Remember to always run the following command whenever you edit files involving HTML:

```bash
npm run build
```

When I ran into an authorization error it was helpful to repeat the following commands:

```bash
chown --recursive --verbose root:www-data .
chmod --recursive 775 bootstrap/cache
chmod --recursive 775 storage
chmod --recursive 775 database
```

I have to remember to issue the following commands when I add a new route and it is not listed:

```bash
php artisan route:cache
php artisan route:clear
php artisan route:list
```

and, if I am examining the presence of a specific route, the following command has been useful to me:

```bash
php artisan route:list | grep "help"
```

## fix coding stile with `pint`

```bash
./vendor/bin/pint --help
./vendor/bin/pint --test
./vendor/bin/pint
```

## update dependencies to the latest version

```bash
composer update --help
composer update --ignore-platform-reqs
```

## examine log files from command line in real time with Laravel `pail`

Well, after creating a new image with `pcntl` enabled and deriving a new container with the associated directory containing the application, I can use the following command to examine the logs in real time:

```bash
php artisan pail
```

## how to check installed packages

```bash
composer show --help
composer show --installed
composer show --installed --tree
composer show --installed | grep laravel
composer show --installed | grep pest
```

## how to check licenses of installed packages

```bash
composer require --dev dominikb/composer-license-checker
./vendor/bin/composer-license-checker help
./vendor/bin/composer-license-checker list
./vendor/bin/composer-license-checker check
./vendor/bin/composer-license-checker report
```
