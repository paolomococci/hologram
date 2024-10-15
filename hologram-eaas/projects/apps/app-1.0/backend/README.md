# `app-be-cntr-1-0`

```bash
ls ~/projects/apps/app-1.0/backend/
cd ~/projects/apps/app-1.0/backend/
```

### solve problems caused by SELinux

The `html` directory can contain either a simple html page or a web application developed using a JavaScript framework.

The best solution in my opinion is to act as the owner of the specific directory:

```bash
mkdir html
ls -lZ
chcon --recursive --type=container_file_t html/
```

### create the container

The `html` directory can contain either a simple info PHP page. But this time the container has all the tools to develop an application from within and the above mentioned directory serves to make this operation permanent, even after the container is stopped.

Here are all the instructions you need to customize an image and get the container working:

```bash
podman image list
podman container list --all
podman run --volume $(pwd)/html:/var/www/html --detach --name app-be-cntr-1-0 --publish 8022:22 --publish 8080:80 --publish 8443:443 --publish 9003:9003 --pull=never  lamp-app-img:1.0.3
podman container list --all --size
podman exec --interactive --tty --privileged app-be-cntr-1-0 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ping -c 3 192.168.1.XXX
ip help
ip link
ip address
ip route
ip neigh
tail --follow --lines=20 /var/log/apache2/access.log
tail --follow --lines=20 /var/log/apache2/error.log
exit
```

### login via OpenSSH

Now I try to log in from the system that hosts the virtual machine that in turn hosts the containers:

```bash
nmap 192.168.1.XXX -Pn -p 8022
ssh root@192.168.1.XXX -p 8022
```

### example of sftp.json for `vscode`

```json
{
    "$schema": "http://json-schema.org/draft-07/schema",
    "name": "app-be-cntr-1-0",
    "username": "root",
    "password": "some_password",
    "host": "192.168.1.XXX",
    "port": 8022,
    "remotePath": "/var/www/html",
    "connectTimeout": 20000,
    "uploadOnSave": true,
    "watcher": {
        "files": "dist/*.{js,css}",
        "autoUpload": false,
        "autoDelete": false
    },
    "syncOption": {
        "delete": true,
        "update": false
    },
    "ignore": [
        ".vscode",
        ".howto",
        ".docs",
        ".git",
        ".DS_Store",
        "TEMP",
        "nbproject",
        "probe.http"
    ]
}
```

### a simple debugging example code

The source of the example follows:

```php
<?php

// example of debugging an iteration that uses a constant

const WELCOME = "Welcome to demo iteration number ";
$sample = "";

toIterate();

function toIterate() {
    for ($i = 0; $i < 10; $i++) {
        xdebug_break();
        $sample = WELCOME . $i . "!<br>";
        echo $sample;
    }
}
```

## scaffolding

Scaffolding of a simple landing application that uses a database to maintain functional data internally thanks to SQLite and an external database that maintains the models of the data of interest thanks to MariaDB.

```bash
composer create-project laravel/laravel landing
cat /etc/passwd | grep 'root'
cat /etc/passwd | grep 'www-data'
chown --recursive --verbose 0:33 landing/
cd landing
composer suggest --all
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

### setup of Jetstream

Considering I'm in the root directory of the project:

```bash
composer require laravel/jetstream
php artisan jetstream:install inertia --teams --dark --ssr
npm install
npm run build
```

### database application setup

Edit `.env`

```text
APP_NAME=landing
APP_ENV=local
...

...
APP_URL=https://192.168.1.XXX:8443/

LANDING_DB_CONNECTION=landingdb
LANDING_DB_HOST=192.168.1.XXX
LANDING_DB_PORT=3306
LANDING_DB_DATABASE=landing-app-db-1-0
LANDING_DB_USERNAME=root
LANDING_DB_PASSWORD=some_password
...
```

I edit the `config/database.php` configuration file appropriately adding this code:

```php
'landingdb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('LANDING_DB_HOST', '127.0.0.1'),
            'port' => env('LANDING_DB_PORT', '3306'),
            'database' => env('LANDING_DB_DATABASE', 'laravel'),
            'username' => env('LANDING_DB_USERNAME', 'root'),
            'password' => env('LANDING_DB_PASSWORD', ''),
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

### add appropriate models for application

Considering I'm in the root directory of the project:

```bash
php artisan make:model --all Author
php artisan make:model --all Article
php artisan make:model --pivot --migration Contributor
chown --recursive --verbose root:www-data .
```

Appropriately modify the files relating to the models and the files relating to the migrations, including the reference to the correct database.

Basically I have to remember to add this code:

```php
protected $connection = 'landingdb';
```

to model classes and migration files!

```bash
php artisan schema:dump
php artisan migrate --pretend
chown --recursive --verbose root:www-data .
php artisan migrate
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
```

### install a collection of Vue composition utilities

Considering I'm in the root directory of the project:

```bash
npm i @vueuse/core
```

### example of repeat migration

```bash
php artisan migrate --path=./database/migrations/time_create_name_table.php
```

### useful notes for solving small problems

I need to remember to always run the following command whenever I modify files that affect views:

```bash
npm run build
```

I have to remember to type the following commands when I add a new route and it is not listed:

```bash
php artisan route:cache
php artisan route:clear
php artisan route:list
```

## stop the container

I can use the container name like this:

```bash
podman stop app-be-cntr-1-0
podman container list --all
```

## restart the container

I can proceed to restarting `app-be-cntr-1-0` in privileged mode:

```bash
podman container list --all
podman start app-be-cntr-1-0
podman exec --interactive --tty --privileged app-be-cntr-1-0 bash
```

## remove container

```bash
podman stop app-be-cntr-1-0 && podman rm app-be-cntr-1-0
podman container list --all
```
