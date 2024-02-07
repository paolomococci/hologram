# Laravel setup

## scaffolding landing app

With developer account:

```bash
cd /var/www/html/
composer create-project laravel/laravel landing
composer require doctrine/dbal
chown --recursive --verbose developer_username:www-data .
cd landing
chmod -R 777 bootstrap/cache
chmod -R 777 storage
```

## update setting files default-ssl.conf and 000-default.conf

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```text
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName www.landing.local
                ServerAlias landing.local
                DocumentRoot /var/www/html/landing/public

                <Directory /var/www/html/landing/public>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                    #Order allow,deny
                    #allow from all
                </Directory>

                LogLevel info ssl:warn

                ErrorLog ${APACHE_LOG_DIR}/landing_error.log
                CustomLog ${APACHE_LOG_DIR}/landing_access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/landing.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/landing.key

                <FilesMatch "\.(cgi|shtml|phtml|php)$">
                    SSLOptions +StdEnvVars
                </FilesMatch>

                <Directory /usr/lib/cgi-bin>
                    SSLOptions +StdEnvVars
                </Directory>
        </VirtualHost>
</IfModule>
```

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

```text
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName www.landing.local
        ServerAlias landing.local
        DocumentRoot /var/www/html/landing/public
        Redirect "/" "https://192.168.1.105/"

        <Directory /var/www/html/landing/public>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
            #Order allow,deny
            #allow from all
        </Directory>

        LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/landing_error.log
        CustomLog ${APACHE_LOG_DIR}/landing_access.log combined
</VirtualHost>
```

Finally:

```bash
apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
sudo systemctl status php-fpm --no-pager
```

### monitoring Apache web server through continuous reading of landing_error.log

```bash
tail -f /var/log/apache2/landing_error.log
```

## I add `user_db`

Now, after logging into the RDBMS as root, I will create a new database `user_db` and then assign privileges to the developer user:

```bash
mariadb -u root -p
```

```sql
SHOW DATABASES;
CREATE DATABASE IF NOT EXISTS `user_db`;
GRANT ALL ON `user_db`.* TO 'developer_username'@'localhost';
GRANT ALL ON `user_db`.* TO 'developer_username'@'%';
FLUSH PRIVILEGES;
```

## configure environment

The application will have access to data recorded in two databases, `user_db` for the proper functioning of the framework and `landing_db` which will receive the application data.

```bash
nano .env
```

```text
...
APP_NAME=landing
...
APP_ENV=local
APP_URL=https://192.168.1.105/

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user_db
DB_USERNAME=developer_username
DB_PASSWORD=some_passwd

LANDING_DB=landing_db
...
```

## databases setup

Open and edit `config/database.php`

```bash
nano config/database.php
```

```php
...
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'landing' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('LANDING_DB', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
...
```

## Jetstream setup

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --teams --dark
npm install
php artisan migrate --pretend
php artisan migrate
chown --recursive --verbose developer_username:www-data .
npm run build
```

## token-based APIs

Open and edit `config/jetstream.php`

```text
...
'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        Features::api(),
        Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],
...
```

## additional models

Now it's time to add the specific models of this application example:

```shell
php artisan make:model --all Author
php artisan make:model --all Article
php artisan make:model --pivot Contributor
php artisan make:migration create_contributor_table --create=contributors
php artisan make:model --pivot --migration Reviewer
```

Attention, the following command deletes all data from the databases of this web application!

```shell
php artisan migrate:fresh
```

## inspect models

Here's how to inspect models and their relationships:

```bash
php artisan model:show Author
php artisan model:show Article
php artisan model:show Contributor
php artisan model:show Reviewer
```