# Apache 2 and PHP 8.3.2

Below we will explain the steps necessary to ensure that the Apache 2 web server uses PHP-FPM (FastCGI Process Manager) compiled from sources.

## download PHP 8.3.2

```bash
cd ~/php
wget https://www.php.net/distributions/php-8.3.2.tar.xz
ls -al
sha256sum php-8.3.2.tar.xz
tar -xJf php-8.3.2.tar.xz
ls -al
cd php-8.3.2/
```

## settings and compilation from PHP version 8.3.2 sources.

```bash
mkdir build_session && cd build_session
../configure --prefix=/opt/php/8.3.2 --enable-fpm --enable-bcmath --enable-opcache --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug
make && make test
sudo make install
```

## setup of php-fpm

```bash
find ~/php/php-8.3.2 -iname 'php.ini*'
sudo cp ~/php/php-8.3.2/php.ini-development /opt/php/8.3.2/lib/php.ini
sudo sed -i 's/;date.timezone =/date.timezone = "Europe\/Rome"/g' /opt/php/8.3.2/lib/php.ini
sudo sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /opt/php/8.3.2/lib/php.ini
sudo sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /opt/php/8.3.2/lib/php.ini
grep -i "max_execution_time"  /opt/php/8.3.2/lib/php.ini
sudo sed -i 's/max_execution_time = 30/max_execution_time = 100/g' /opt/php/8.3.2/lib/php.ini
grep -i "upload_max_filesize"  /opt/php/8.3.2/lib/php.ini
sudo sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/g' /opt/php/8.3.2/lib/php.ini
sudo cp /opt/php/8.3.2/etc/php-fpm.conf.default /opt/php/8.3.2/etc/php-fpm83.conf
sudo sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm83.pid/g' /opt/php/8.3.2/etc/php-fpm83.conf
```

Obviously the `timezone` must be set in the most appropriate way because it depends on where the server is located.

At the end of the `/opt/php/8.3.2/etc/php-fpm83.conf` file add the following lines:

```text
...
user = www-data
group = www-data
```

with the following commands, then verifying the outcome:

```bash
sudo sed -i '$auser = www-data' /opt/php/8.3.2/etc/php-fpm83.conf
sudo sed -i '$agroup = www-data' /opt/php/8.3.2/etc/php-fpm83.conf
tail /opt/php/8.3.2/etc/php-fpm83.conf
```

Now copy `www.conf`:

```bash
sudo cp /opt/php/8.3.2/etc/php-fpm.d/www.conf.default /opt/php/8.3.2/etc/php-fpm.d/www.conf
ls -al /usr/lib/systemd/system/
```

I create the configuration file `php-fpm83.service`:

```bash
sudo nano /usr/lib/systemd/system/php-fpm83.service
```

```text
[Unit]
Description=PHP 8.3.2 FastCGI Process Manager
After=network.target

[Service]
Type=simple
PIDFile=/opt/php/8.3.2/var/run/php-fpm83.pid
ExecStart=/opt/php/8.3.2/sbin/php-fpm --nodaemonize --fpm-config /opt/php/8.3.2/etc/php-fpm83.conf
ExecReload=/bin/kill -USR2 $MAINPID

[Install]
WantedBy=multi-user.target
```

Enable Zend OPcache:

```bash
grep -i "zend_extension" /opt/php/8.3.2/lib/php.ini
sudo sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.3.2/lib/php.ini
```

## now I try to start the newly created service:

```bash
sudo systemctl status php-fpm83
sudo systemctl enable php-fpm83
sudo systemctl daemon-reload
sudo systemctl start php-fpm83
sudo systemctl status php-fpm83 --no-pager
```

If there are problems, investigate with:

```bash
journalctl -b -u php-fpm83 --no-pager
```

## make Apache work together with PHP-FPM

I change the module's listening mode from socket TCP to socket UNIX:

```bash
sudo sed -i 's/^user = nobody/;user = nobody/g' /opt/php/8.3.2/etc/php-fpm.d/www.conf
sudo sed -i 's/^group = nobody/;group = nobody/g' /opt/php/8.3.2/etc/php-fpm.d/www.conf
sudo sed -i 's/^listen = 127.0.0.1:9000/;listen = 127.0.0.1:9000/g' /opt/php/8.3.2/etc/php-fpm.d/www.conf
sudo sed -i '$a; UNIX socket' /opt/php/8.3.2/etc/php-fpm.d/www.conf
sudo sed -i '$alisten = /run/php-fpm83.sock' /opt/php/8.3.2/etc/php-fpm.d/www.conf
sudo sed -i '$alisten.owner = www-data' /opt/php/8.3.2/etc/php-fpm.d/www.conf
sudo sed -i '$alisten.group = www-data' /opt/php/8.3.2/etc/php-fpm.d/www.conf
tail /opt/php/8.3.2/etc/php-fpm.d/www.conf
cat /opt/php/8.3.2/etc/php-fpm.d/www.conf | grep -i "user = nobody"
cat /opt/php/8.3.2/etc/php-fpm.d/www.conf | grep -i "group = nobody"
cat /opt/php/8.3.2/etc/php-fpm.d/www.conf | grep -i "listen = 127.0.0.1:9000"
```

## match FPM with Apache

```bash
sudo nano /etc/apache2/conf-available/php-fpm83.conf
```

Edit:

```xml
<FilesMatch ".+\.php$">
    SetHandler "proxy:unix:/run/php-fpm83.sock|fcgi://localhost"
</FilesMatch>

<IfModule mod_dir.c>
    DirectoryIndex index.php index.html
</IfModule>

<FilesMatch "^.ph(?:ar|p|ps|tml)$">
    Require all denied
</FilesMatch>
```

## .htaccess

First I checked that some modules are enabled:

```bash
apachectl -M | grep "proxy_fcgi"
apachectl -M | grep "setenvif"
```

and if necessary:

```bash
sudo a2enmod proxy_fcgi
sudo a2enmod setenvif
```

On document root I have create a file `.htaccess` with following content:

```xml
<FilesMatch ".+\.php$">
    SetHandler "proxy:unix:/run/php-fpm83.sock|fcgi://localhost"
</FilesMatch>
```

```bash
sudo service php-fpm83 restart
```

and I check existence of this file:

```bash
ls -al /run/php-fpm83.sock
```

Remembering that in an unix like system everything is a file.

However, if necessary you can use the following commands to investigate and remedy some configuration errors:

```bash
apachectl configtest
sudo systemctl reload apache2
sudo systemctl status apache2 --no-pager
journalctl -b -u php-fpm83 --no-pager
sudo systemctl restart php-fpm83
sudo systemctl status php-fpm83 --no-pager
```

and I can consult the log files:

```bash
tail --lines=10 --verbose --follow --retry /var/log/apache2/vh83_error.log
```
