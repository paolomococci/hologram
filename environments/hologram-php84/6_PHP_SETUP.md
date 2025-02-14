# Apache 2 and PHP 8.4.4

Below we will explain the steps necessary to ensure that the Apache 2 web server uses PHP-FPM (FastCGI Process Manager) compiled from sources.

## download PHP 8.4.4

```bash
cd ~
mkdir php && cd php
```

First I can check the existence of the archive:

```bash
wget --spider --https-only https://www.php.net/distributions/php-8.4.4.tar.xz
```

After that I can download the archive containing the sources:

```bash
wget --https-only https://www.php.net/distributions/php-8.4.4.tar.xz
ls -l
sha256sum php-8.4.4.tar.xz
tar -xf php-8.4.4.tar.xz
ls -l
cd php-8.4.4/
```

## settings and compilation from PHP version 8.4.4 sources.

```bash
mkdir build_session && cd build_session
../configure --help | grep -i "opcache"
../configure --prefix=/opt/php/8.4.4 --enable-fpm --enable-bcmath --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug --with-ffi --with-zip
make
make test
sudo make install
cd ~
```

## setup of php-fpm

```bash
su -
cd ~
find /home/developer_username/php/php-8.4.4 -iname 'php.ini*'
cp /home/developer_username/php/php-8.4.4/php.ini-development /opt/php/8.4.4/lib/php.ini
sed -i 's/;date.timezone =/date.timezone = "Europe\/Rome"/g' /opt/php/8.4.4/lib/php.ini
sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /opt/php/8.4.4/lib/php.ini
sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /opt/php/8.4.4/lib/php.ini
grep -i "max_execution_time" /opt/php/8.4.4/lib/php.ini
sed -i 's/max_execution_time = 30/max_execution_time = 100/g' /opt/php/8.4.4/lib/php.ini
grep -i "upload_max_filesize" /opt/php/8.4.4/lib/php.ini
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/g' /opt/php/8.4.4/lib/php.ini
cp /opt/php/8.4.4/etc/php-fpm.conf.default /opt/php/8.4.4/etc/php-fpm.conf
sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.4.4/etc/php-fpm.conf
```

Optionally I prefer to set the language option `short_open_tag` to `On`:

```bash
grep -i "short_open_tag = Off" /opt/php/8.4.4/lib/php.ini
sed -i 's/short_open_tag = Off/short_open_tag = On/g' /opt/php/8.4.4/lib/php.ini
```

## check of privileged and system user identifiers

```bash
cat /etc/passwd | grep 'root'
cat /etc/passwd | grep 'apache'
```

Obviously the `timezone` must be set in the most appropriate way because it depends on where the server is located.

At the end of the `/opt/php/8.4.4/etc/php-fpm.conf` file

```bash
nano /opt/php/8.4.4/etc/php-fpm.conf
```

add the following lines:

```text
...
user = apache
group = apache
```

But it is better to modify with sed and then check the result:

```bash
sed -i '$auser = apache' /opt/php/8.4.4/etc/php-fpm.conf
sed -i '$agroup = apache' /opt/php/8.4.4/etc/php-fpm.conf
tail /opt/php/8.4.4/etc/php-fpm.conf
```

Now copy `www.conf`:

```bash
cp /opt/php/8.4.4/etc/php-fpm.d/www.conf.default /opt/php/8.4.4/etc/php-fpm.d/www.conf
ls -al /usr/lib/systemd/system/ | grep -i "php-fpm.service"
```

If it doesn't exist yet, I create the configuration file `php-fpm.service`:

```bash
nano /usr/lib/systemd/system/php-fpm.service
```

```text
[Unit]
Description=PHP 8.4.4 FastCGI Process Manager
After=network.target

[Service]
Type=simple
PIDFile=/opt/php/8.4.4/var/run/php-fpm.pid
ExecStart=/opt/php/8.4.4/sbin/php-fpm --nodaemonize --fpm-config /opt/php/8.4.4/etc/php-fpm.conf
ExecReload=/bin/kill -USR2 $MAINPID

[Install]
WantedBy=multi-user.target
```

Or better yet, if the file just needs modifications:

```bash
sed -i 's/8.4.3/8.4.4/g' /usr/lib/systemd/system/php-fpm.service
```

Enable Zend OPcache:

```bash
grep -i "zend_extension" /opt/php/8.4.4/lib/php.ini
sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.4.4/lib/php.ini
```

## now I try to start the newly created service:

```bash
systemctl status php-fpm
systemctl enable php-fpm
systemctl daemon-reload
systemctl start php-fpm
systemctl status php-fpm --no-pager
```

But if I'm updating it's better:

```bash
systemctl daemon-reload
systemctl restart php-fpm
systemctl status php-fpm --no-pager
```

If there are problems, investigate with:

```bash
journalctl -b -u php-fpm
```

## make Apache work together with PHP-FPM

During the next step, I have to be very careful.
I change the module's listening mode from socket TCP to socket UNIX:

```bash
nano /opt/php/8.4.4/etc/php-fpm.d/www.conf
```

```text
user = apache
group = apache

; TCP socket
listen = 127.0.0.1:9000
```

Similar to what was done before, it is better to modify with `sed` and then check the result:

```bash
sed -i 's/^user = nobody/user = apache/g' /opt/php/8.4.4/etc/php-fpm.d/www.conf
sed -i 's/^group = nobody/group = apache/g' /opt/php/8.4.4/etc/php-fpm.d/www.conf
grep -i "listen = 127.0.0.1:9000" /opt/php/8.4.4/etc/php-fpm.d/www.conf
```

## match FPM with Apache

```bash
nano /etc/httpd/conf.d/php-fpm.conf
```

Edit as follows to complete the `TCP socket` approach:

```xml
<FilesMatch ".+\.php$">
    SetHandler "proxy:fcgi://127.0.0.1:9000"
</FilesMatch>

<IfModule mod_dir.c>
    DirectoryIndex index.php index.html
</IfModule>

<FilesMatch "^.ph(?:ar|p|ps|tml)$">
    Require all denied
</FilesMatch>
```

and type:

```bash
systemctl restart httpd
systemctl status httpd --no-pager
systemctl restart php-fpm
systemctl status php-fpm --no-pager
```

First I checked that some modules are enabled:

```bash
httpd -M
grep -R "mod_proxy" /etc/httpd/
grep -R "setenvif" /etc/httpd/
```

Naturally, if they are not, they must be enabled, as happened to me for example with the module `proxy_fcgi`.

Finally, I can do one last check and enable module `php-fpm`:

```bash
apachectl configtest
systemctl restart httpd
systemctl restart php-fpm
systemctl status httpd --no-pager
systemctl status php-fpm --no-pager
```

In case of update:

```bash
systemctl restart httpd
systemctl restart php-fpm
systemctl status httpd --no-pager
systemctl status php-fpm --no-pager
```

## final setup

To enable the developer user to create and edit web application files:

```bash
ls -l /var/www/html/
ps aux | grep apache
getent group
usermod -a -G apache developer_username
groups developer_username
chown --recursive developer_username:apache /var/www/html/
ls -l /var/www/html/
```

### SELinux

Be careful, it is important to remember that `SELinux` interferes with the normal functioning of `php-fpm`.

Once you have verified what has just been written:

```bash
su -
setenforce 0
getenforce
setenforce 1
getenforce
```

I will have to proceed to solve the problem without compromising the security of the system:

```bash
su -
ls -lZ /var/www/html/
restorecon -r /var/www/html/
sestatus
setsebool -P httpd_can_network_connect on
```

Now I restart the affected services again and check that they are working correctly:

```bash
systemctl restart httpd
systemctl restart php-fpm
systemctl status httpd --no-pager
systemctl status php-fpm --no-pager
tail -f /opt/php/8.4.4/var/log/php-fpm.log
tail -f /var/log/httpd/error_log
exit
```
