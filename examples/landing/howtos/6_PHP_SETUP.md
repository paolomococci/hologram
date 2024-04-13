# Apache 2 and PHP 8.3.6

Below we will explain the steps necessary to ensure that the Apache 2 web server uses PHP-FPM (FastCGI Process Manager) compiled from sources.

## download PHP 8.3.6

```bash
cd ~
mkdir php && cd php
wget https://www.php.net/distributions/php-8.3.6.tar.xz
ls -al
sha256sum php-8.3.6.tar.xz
tar -xvf php-8.3.6.tar.xz
ls -al
cd php-8.3.6/
```

## settings and compilation from PHP version 8.3.6 sources.

```bash
mkdir build_session && cd build_session
../configure --help | grep -i "opcache"
../configure --prefix=/opt/php/8.3.6 --enable-fpm --enable-bcmath --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug
make
make test
sudo make install
```

## setup of php-fpm

```bash
find ~/php/php-8.3.6 -iname 'php.ini*'
sudo cp ~/php/php-8.3.6/php.ini-development /opt/php/8.3.6/lib/php.ini
sudo sed -i 's/;date.timezone =/date.timezone = "Europe\/Rome"/g' /opt/php/8.3.6/lib/php.ini
sudo sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /opt/php/8.3.6/lib/php.ini
sudo sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /opt/php/8.3.6/lib/php.ini
grep -i "max_execution_time"  /opt/php/8.3.6/lib/php.ini
sudo sed -i 's/max_execution_time = 30/max_execution_time = 100/g' /opt/php/8.3.6/lib/php.ini
grep -i "upload_max_filesize"  /opt/php/8.3.6/lib/php.ini
sudo sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/g' /opt/php/8.3.6/lib/php.ini
sudo cp /opt/php/8.3.6/etc/php-fpm.conf.default /opt/php/8.3.6/etc/php-fpm.conf
sudo sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.3.6/etc/php-fpm.conf
```

Obviously the `timezone` must be set in the most appropriate way because it depends on where the server is located.

When and if I want to use short tags in PHP files, I will need to make the following change to the `php.ini` file:

```bash
grep -i "short_open_tag = Off"  /opt/php/8.3.6/lib/php.ini
sudo sed -i 's/short_open_tag = Off/short_open_tag = On/g' /opt/php/8.3.6/lib/php.ini
```

At the end of the `/opt/php/8.3.6/etc/php-fpm.conf` file 

```bash
sudo nano /opt/php/8.3.6/etc/php-fpm.conf
```

add the following lines:

```text
...
user = www-data
group = www-data
```

But it is better to modify with sed and then check the result:

```bash
sudo sed -i '$auser = www-data' /opt/php/8.3.6/etc/php-fpm.conf
sudo sed -i '$agroup = www-data' /opt/php/8.3.6/etc/php-fpm.conf
tail /opt/php/8.3.6/etc/php-fpm.conf
```

Now copy `www.conf`:

```bash
sudo cp /opt/php/8.3.6/etc/php-fpm.d/www.conf.default /opt/php/8.3.6/etc/php-fpm.d/www.conf
ls -al /usr/lib/systemd/system/
```

I create the configuration file `php-fpm.service`:

```bash
sudo nano /usr/lib/systemd/system/php-fpm.service
```

```text
[Unit]
Description=PHP 8.3.6 FastCGI Process Manager
After=network.target

[Service]
Type=simple
PIDFile=/opt/php/8.3.6/var/run/php-fpm.pid
ExecStart=/opt/php/8.3.6/sbin/php-fpm --nodaemonize --fpm-config /opt/php/8.3.6/etc/php-fpm.conf
ExecReload=/bin/kill -USR2 $MAINPID

[Install]
WantedBy=multi-user.target
```

Or better:

```bash
sudo sed -i 's/8.3.4/8.3.6/g' /usr/lib/systemd/system/php-fpm.service
```

Enable Zend OPcache:

```bash
grep -i "zend_extension" /opt/php/8.3.6/lib/php.ini
sudo sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.3.6/lib/php.ini
```

## make Apache work together with PHP-FPM

```bash
sudo nano /opt/php/8.3.6/etc/php-fpm.d/www.conf
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

## now I try to start the newly created service:

```bash
sudo systemctl status php-fpm --no-pager
sudo systemctl enable php-fpm
sudo systemctl daemon-reload
sudo systemctl start php-fpm
sudo systemctl status php-fpm --no-pager
```

But if I'm updating it's better:

```bash
sudo systemctl daemon-reload
sudo systemctl restart php-fpm
sudo systemctl status php-fpm --no-pager
```

If there are problems, investigate with:

```bash
journalctl -b -u php-fpm
```

First I checked that some modules are enabled:

```bash
apachectl -M | grep "proxy_fcgi"
apachectl -M | grep "setenvif"
sudo a2enmod proxy_fcgi
```

Naturally, if they are not, they must be enabled, as happened to me for example with the module `proxy_fcgi`.

Finally, I can do one last check and enable module `php-fpm`:

```bash
apachectl configtest
sudo a2enconf php-fpm
sudo systemctl restart apache2
sudo systemctl restart php-fpm
sudo systemctl status apache2 --no-pager
sudo systemctl status php-fpm --no-pager
```

In case of update:

```bash
sudo systemctl restart apache2
sudo systemctl restart php-fpm
sudo systemctl status apache2 --no-pager
sudo systemctl status php-fpm --no-pager
```

If problems arise, it will be necessary to issue the following commands: 

```bash
sudo a2disconf php-fpm
sudo systemctl reload apache2
```

and consult the log files.

## make PHP accessible globally not just from Apache

Attention, it will be necessary to delete the symbolic links if they already exist.
Since, in this example I have just compiled a newer version of PHP, the aforementioned symlinks will already be present and will point to the older version.

```bash
sudo ln --symbolic --verbose /opt/php/8.3.6/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.6/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.6/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.6/bin/php-config /usr/bin/php-config
```

Update `locate` cache:

```bash
sudo updatedb
locate php.ini
```
