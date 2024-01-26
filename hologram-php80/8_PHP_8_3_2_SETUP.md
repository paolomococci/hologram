# PHP 8.3.2

## download PHP 8.3.2

```bash
cd ~/php
wget https://www.php.net/distributions/php-8.3.2.tar.xz
ls -al
sha256sum php-8.3.2.tar.xz
unxz php-8.3.2.tar.xz
tar -xvf php-8.3.2.tar
ls -al
cd php-8.3.2/
```

## settings and compilation from PHP version 8.3.2 sources.

```bash
mkdir build_session && cd build_session
../configure --prefix=/opt/php/8.3.2 --enable-fpm --enable-bcmath --enable-opcache --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug
make
make test
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
sudo cp /opt/php/8.3.2/etc/php-fpm.conf.default /opt/php/8.3.2/etc/php-fpm.conf
sudo sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.3.2/etc/php-fpm.conf
```

At the end of the `/opt/php/8.3.2/etc/php-fpm.conf` file add the following lines:

```text
...
user = www-data
group = www-data
```

with the following commands, then verifying the outcome:

```bash
sudo sed -i '$auser = www-data' /opt/php/8.3.2/etc/php-fpm.conf
sudo sed -i '$agroup = www-data' /opt/php/8.3.2/etc/php-fpm.conf
tail /opt/php/8.3.2/etc/php-fpm.conf
```

Now copy `www.conf`:

```bash
sudo cp /opt/php/8.3.2/etc/php-fpm.d/www.conf.default /opt/php/8.3.2/etc/php-fpm.d/www.conf
ls -al /usr/lib/systemd/system/
```

I create the configuration file `php-fpm.service`:

```bash
sudo nano /usr/lib/systemd/system/php-fpm.service
```

Enable Zend OPcache:

```bash
grep -i "zend_extension" /opt/php/8.3.2/lib/php.ini
sudo sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.3.2/lib/php.ini
```
