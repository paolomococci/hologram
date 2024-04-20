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
