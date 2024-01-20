# steps necessary for CMS setup

1. I check support to `mysqli`, (MySQL Improved Extension):

To check version and extensions of PHP:

```bash
php -v
php -m | grep "mysqli"
```

To check `memory_limit` on `php.ini` file:

```bash
grep -i "memory_limit"  /opt/php/8.3.1/lib/php.ini
```

I check and reload the `php-fpm` service:

```bash
sudo systemctl reload php-fpm
sudo systemctl status php-fpm --no-pager
```

2. I scaffold the project with Composer and start the setup:

```bash
cd /var/www/html/
composer create-project drupal/recommended-project landing
cd landing/
composer remove drupal/core-project-message
composer require --dev drush/drush
./vendor/bin/drush --version
```

Modify the configuration files as desired:

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```xml
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost

                DocumentRoot /var/www/html/landing/web

                <Directory /var/www/html/landing/web>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                </Directory>

                LogLevel warn

                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/gutter.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/gutter.key

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
        DocumentRoot /var/www/html/landing/web
        Redirect "/" "https://192.168.1.XXX/"

        <Directory /var/www/html/landing/web>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

To then activate the new settings:

```bash
apache2ctl configtest
sudo systemctl reload apache2
sudo systemctl status apache2 --no-pager
```

Create the folder and file that the system will use to write settings:

```bash
cd web/sites/default/
mkdir files
chmod 777 files
touch settings.php
chmod 666 settings.php
chown --recursive developer_username:www-data .
```

Now I can point the browser to IP address `https://192.168.1.XXX` and then follow the guided settings.

3. I install the CMS and complete the setup:

Before starting I need to write down some data to enter during the guided installation:

* database name: `gutter_db`
* database username: `admin`
* database password: `any_password`

in the advanced options I replace `localhost` with `127.0.0.1`

* table prefix: `gutter_`

Now is necessary change permission on `sites/default/files` and `sites/default/settings.php`:

```bash
chmod 755 files
chmod 644 settings.php
```

To complete the CMS setup I must also note down the following parameters:

* site name: `gutter`
* site email address: `webmaster@localhost`
* site maintenance username: `editor`
* site maintenance password: `any_other_password`
* site maintenance email: `webmaster@localhost`
