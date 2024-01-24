# Apache 2 and PHP 8.3.1

Below we will explain the steps necessary to ensure that the Apache 2 web server uses PHP-FPM (FastCGI Process Manager) compiled from sources.

## download PHP 8.3.1

```bash
cd ~
mkdir php && cd php
wget https://www.php.net/distributions/php-8.3.1.tar.bz2
ls -al
sha256sum php-8.3.1.tar.bz2
tar -xvjf php-8.3.1.tar.bz2
ls -al
cd php-8.3.1/
```

## settings and compilation from PHP version 8.3.1 sources.

```bash
mkdir build_session && cd build_session
../configure --prefix=/opt/php/8.3.1 --enable-fpm --enable-bcmath --enable-opcache --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug
make
make test
sudo make install
```

## setup of php-fpm

```bash
find ~/php/php-8.3.1 -iname 'php.ini*'
sudo cp ~/php/php-8.3.1/php.ini-development /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/;date.timezone =/date.timezone = "Europe\/Rome"/g' /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /opt/php/8.3.1/lib/php.ini
grep -i "max_execution_time"  /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/max_execution_time = 30/max_execution_time = 100/g' /opt/php/8.3.1/lib/php.ini
grep -i "upload_max_filesize"  /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/g' /opt/php/8.3.1/lib/php.ini
sudo cp /opt/php/8.3.1/etc/php-fpm.conf.default /opt/php/8.3.1/etc/php-fpm.conf
sudo sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.3.1/etc/php-fpm.conf
```

Obviously the `timezone` must be set in the most appropriate way because it depends on where the server is located.

At the end of the `/opt/php/8.3.1/etc/php-fpm.conf` file 

```bash
sudo nano /opt/php/8.3.1/etc/php-fpm.conf
```

add the following lines:

```text
...
user = www-data
group = www-data
```

Now copy `www.conf`:

```bash
sudo cp /opt/php/8.3.1/etc/php-fpm.d/www.conf.default /opt/php/8.3.1/etc/php-fpm.d/www.conf
ls -al /usr/lib/systemd/system/
```

I create the configuration file `php-fpm.service`:

```bash
nano /usr/lib/systemd/system/php-fpm.service
```

```text
[Unit]
Description=PHP 8.3.1 FastCGI Process Manager
After=network.target

[Service]
Type=simple
PIDFile=/opt/php/8.3.1/var/run/php-fpm.pid
ExecStart=/opt/php/8.3.1/sbin/php-fpm --nodaemonize --fpm-config /opt/php/8.3.1/etc/php-fpm.conf
ExecReload=/bin/kill -USR2 $MAINPID

[Install]
WantedBy=multi-user.target
```

Enable Zend OPcache:

```bash
grep -i "zend_extension" /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.3.1/lib/php.ini
```

## now I try to start the newly created service:

```bash
sudo systemctl status php-fpm.service
sudo systemctl enable php-fpm.service
sudo systemctl daemon-reload
sudo systemctl start php-fpm.service
sudo systemctl status php-fpm.service
```

If there are problems, investigate with:

```bash
journalctl -b -u php-fpm
```

## make Apache work together with PHP-FPM

```bash
sudo nano /opt/php/8.3.1/etc/php-fpm.d/www.conf
```

I change the module's listening mode from socket TCP to socket UNIX:

```text
...
;user = nobody
;group = nobody
;user = www-data
;group = www-data

; TCP socket
;listen = 127.0.0.1:9000
;listen.allowed_clients = 127.0.0.1

; UNIX socket
listen = /run/php-fpm.sock
listen.owner = www-data
listen.group = www-data
...
```

## match FPM with Apache

```bash
sudo nano /etc/apache2/conf-available/php-fpm.conf
```

Edit:

```xml
<FilesMatch ".+\.php$">
    SetHandler "proxy:unix:/run/php-fpm.sock|fcgi://localhost"
</FilesMatch>

<IfModule mod_dir.c>
    DirectoryIndex index.php index.html
</IfModule>

<FilesMatch "^.ph(?:ar|p|ps|tml)$">
    Require all denied
</FilesMatch>
```

And finally:

```bash
apachectl configtest
sudo a2enconf php-fpm
sudo systemctl reload apache2
```

If problems arise, it will be necessary to issue the following commands: 

```bash
sudo a2disconf php-fpm
sudo systemctl reload apache2
```

and consult the log files.
