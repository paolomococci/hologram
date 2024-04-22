# `quotes` version 3

```bash
cd /var/www/html/v3/
composer create-project laravel/laravel:^11.0 quotes
chown --recursive --verbose developer_username:www-data .
cd quotes
chmod --recursive 775 bootstrap/cache
chmod --recursive 775 storage
chmod --recursive 775 database
```

### Apache 2 setup

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```xml
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName quotes.local
                ServerAlias www.quotes.local
                DocumentRoot /var/www/html/v3/quotes/public

                <Directory /var/www/html/v3/quotes/public>
                        Options Indexes FollowSymLinks MultiViews
                        AllowOverride All
                        Require all granted
                </Directory>

                LogLevel warn

                ErrorLog ${APACHE_LOG_DIR}/quotes_v3_error.log
                CustomLog ${APACHE_LOG_DIR}/quotes_v3_access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/quotes.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/quotes.key

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

```xml
<VirtualHost *:80>

        ServerAdmin webmaster@localhost
        ServerName quotes.local
        ServerAlias www.quotes.local
        DocumentRoot /var/www/html/v3/quotes/public
        Redirect "/" "https://192.168.1.103/"

        <Directory /var/www/html/v3/quotes/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/quotes_v3_error.log
        CustomLog ${APACHE_LOG_DIR}/quotes_v3_access.log combined

</VirtualHost>
```

or better:

```bash
sudo sed -i 's/v2/v3/g' /etc/apache2/sites-available/default-ssl.conf
sudo sed -i 's/v2/v3/g' /etc/apache2/sites-available/000-default.conf
```

```bash
apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
sudo systemctl status php-fpm --no-pager
tail -f /var/log/apache2/quotes_v3_error.log
tail -f /var/log/apache2/quotes_v3_access.log
```

### database setup

```bash
mariadb -u root -p
```

```sql
SHOW DATABASES;
CREATE DATABASE IF NOT EXISTS `laravel_v3_db`;
CREATE DATABASE IF NOT EXISTS `quotes_v3_db`;
GRANT ALL ON `laravel_v3_db`.* TO 'developer_username'@'localhost';
GRANT ALL ON `quotes_v3_db`.* TO 'developer_username'@'localhost';
GRANT ALL ON `laravel_v3_db`.* TO 'developer_username'@'%';
GRANT ALL ON `quotes_v3_db`.* TO 'developer_username'@'%';
FLUSH PRIVILEGES;
quit
```

### edit `.env`

```text
APP_NAME=quotes
APP_ENV=local
...

APP_URL=https://192.168.1.XXX/
...


DB_CONNECTION=sqlite

LARAVEL_v3_DB_CONNECTION=mariadb
LARAVEL_v3_DB_HOST=127.0.0.1
LARAVEL_v3_DB_PORT=3306
LARAVEL_v3_DB_DATABASE=laravel_v3_db
LARAVEL_v3_DB_USERNAME=developer_username
LARAVEL_v3_DB_PASSWORD=db_password

QUOTES_v3_DB=quotes_v3_db
...
```

Edit the `config/database.php` configuration file appropriately.

## add appropriate models for application

Considering I'm in the root directory of the project:

```bash
php artisan make:model --all Author
php artisan make:model --all Article
php artisan make:model --pivot --migration Merit
php artisan make:model --all Paper
chown --recursive --verbose developer_username:www-data .
```

Appropriately modify the files relating to the models and the files relating to the migrations, including the reference to the correct database.

## setup of Jetstream

Considering I'm in the root directory of the project:

```bash
composer require laravel/jetstream
php artisan jetstream:install inertia --teams --dark --ssr
npm install
npm run build
```

Remember to comment out the default setting to SQLite and set the correct default database in the `config/database.php` file:

```php
...
// 'default' => env('DB_CONNECTION', 'sqlite'),
    'default' => env('LARAVEL_V3_DB_CONNECTION', 'laraveldb'),
...
```

```bash
php artisan migrate --pretend
sudo chown --recursive --verbose developer_username:www-data .
php artisan migrate
```

## install a collection of Vue composition utilities

Considering I'm in the root directory of the project:

```bash
npm i @vueuse/core
```

## allow the use of APIs

Edit the `config/jetstream.php` file, just uncomment the following line :

```php
...
Features::api(),
...
```

## encountering a problem: `Call to undefined method App\Models\User::ownedTeams()`

I had to change the code of model `User` from like this:

```php
...
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
...
```

to like this:

```php
...
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
...
```

Then I had to add the following two lines of code to the file that migrates model `User`:

```php
...
$table->foreignId('current_team_id')->nullable();
$table->string('profile_photo_path', 2048)->nullable();
...
```

and repeat the migration for table `users`:

```bash
php artisan migrate --pretend --path=./database/migrations/0001_01_01_000000_create_users_table.php
php artisan migrate --path=./database/migrations/0001_01_01_000000_create_users_table.php
```
