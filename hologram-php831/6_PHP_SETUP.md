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
../configure --prefix=/opt/php/8.3.1 --enable-fpm --enable-bcmath --enable-opcache --enable-ftp --with-openssl-dir=/usr/bin/openssl --disable-cgi --enable-mbstring --with-curl --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug
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
grep -i "max_execution_time"  /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/max_execution_time = 30/max_execution_time = 100/g' /opt/php/8.3.1/lib/php.ini
grep -i "upload_max_filesize"  /opt/php/8.3.1/lib/php.ini
sudo sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/g' /opt/php/8.3.1/lib/php.ini
sudo cp /opt/php/8.3.1/etc/php-fpm.conf.default /opt/php/8.3.1/etc/php-fpm.conf
sudo sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.3.1/etc/php-fpm.conf
```

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
