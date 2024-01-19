# steps necessary for CMS setup

1. I add support to `mysqli`, (MySQL Improved Extension):

It is necessary to recompile from source PHP because drupal require the `mysqli` PHP extension is installed and enabled:

```bash
cd ~/php/php-8.3.1/
./configure --help | grep "mysqli"
mkdir build_session && cd build_session
../configure --prefix=/opt/php/8.3.1 --enable-fpm --enable-bcmath --enable-opcache --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug
make
make test
sudo make install
```

I compare the configuration files with the backups made before repeating the compilation to make sure there are no inadvertent changes:

```bash
cd ~/php/backup_config_files/
sudo diff /opt/php/8.3.1/lib/php.ini ./php.ini
sudo diff /opt/php/8.3.1/etc/php-fpm.conf ./php-fpm.conf
sudo diff /opt/php/8.3.1/etc/php-fpm.d/www.conf ./www.conf
```

I increase `memory_limit` on `php.ini` file:

```bash
grep -i "memory_limit"  /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /opt/php/8.3.1/lib/php.ini
```

I check and reload the `php-fpm` service:

```bash
sudo systemctl reload php-fpm
sudo systemctl status php-fpm --no-pager
```

To check version and extensions of PHP:

```bash
php -v
php -m | grep "mysqli"
```

2. I create the database and its administrator user:

Create a user `admin_dp` and `data_dp` database:

User `admin_dp` on `localhost`

```sql
SHOW DATABASES;
SELECT PASSWORD('any_password');
CREATE USER IF NOT EXISTS 'admin_dp'@'localhost' IDENTIFIED BY PASSWORD 'any_hashed_password';
CREATE DATABASE IF NOT EXISTS `data_dp`;
GRANT ALL ON `data_dp`.* TO 'admin_dp'@'localhost';
FLUSH PRIVILEGES;
SELECT `user`, `password`, `host`, `Super_priv` FROM `mysql`.`user`;
```

User `admin_dp` on `192.168.1.1`

```sql
CREATE USER IF NOT EXISTS 'admin_dp'@'192.168.1.1' IDENTIFIED BY PASSWORD 'any_hashed_password';
GRANT ALL ON `data_dp`.* TO 'admin_dp'@'192.168.1.1';
FLUSH PRIVILEGES;
SELECT `user`, `password`, `host`, `Super_priv` FROM `mysql`.`user`;
```

3. I download the compressed archive of `CMS` and start the setup:

```bash
mkdir ~/drupal && cd ~/drupal
curl -sSL https://www.drupal.org/download-latest/tar.gz | tar -xz --strip-components=1
cd ~
cp --recursive ./drupal/ /var/www/html/drupal
cd /var/www/html/drupal/
chown --recursive developer_username:www-data .
chmod --recursive 755 .
cd sites/default/
mkdir files
chmod 777 files
touch settings.php
chmod 666 settings.php
```

Once the installation was complete I adjusted the permissions of directory `files` and file `settings.php`:

```bash
chmod 755 files
chmod 644 settings.php
```

If at a certain point I want to start again from a clean development environment:

```bash
rm -rf vendor
composer install
```

Now I need to point the browser to the following address:

<https://192.168.1.XXX/drupal/core/index.php>

and I follow the instructions.

4. I install the CMS and complete the setup:

Before starting I need to write down some data to enter during the guided installation:

* database name: `data_dp`
* database username: `admin_dp`
* database password: `any_password`
* database host: `127.0.0.1`

To complete the CMS setup I must also note down the following parameters:

* site name: `hologram-dp`
* site email address: `webmaster@localhost`
* site maintenance username: `editor_dp`
* site maintenance password: `any_other_password`
* site maintenance email: `webmaster@localhost`

5. Modify the configuration files as desired:

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```xml
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost

                DocumentRoot /var/www/html/drupal

                <Directory /var/www/html/drupal>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                </Directory>

                LogLevel warn

                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/hologram-dp.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/hologram-dp.key

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
        DocumentRoot /var/www/html/drupal
        Redirect "/" "https://192.168.1.XXX/"

        <Directory /var/www/html/drupal>
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
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
```
