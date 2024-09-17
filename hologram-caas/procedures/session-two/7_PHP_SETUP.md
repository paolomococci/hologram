# Apache 2 and PHP 8.3.11

Below we will explain the steps necessary to ensure that the Apache 2 web server uses PHP-FPM (FastCGI Process Manager) compiled from sources.

## download PHP 8.3.11

```bash
cd ~
mkdir php && cd php
wget https://www.php.net/distributions/php-8.3.11.tar.xz
ls -l
sha256sum php-8.3.11.tar.xz
tar -xf php-8.3.11.tar.xz
ls -l
cd php-8.3.11/
```

## settings and compilation from PHP version 8.3.11 sources.

```bash
mkdir build_session && cd build_session
../configure --help | grep -i "opcache"
../configure --prefix=/opt/php/8.3.11 --enable-fpm --enable-bcmath --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug --with-ffi --with-readline
make
make test
sudo make install
```

## make PHP accessible globally

Quick warning, if the following links are already there, you will need to remove them first. To then recreate new ones that point to the newly installed versions.

```bash
sudo rm /usr/bin/php
sudo rm /usr/bin/phar
sudo rm /usr/bin/phpize
sudo rm /usr/bin/php-config
```

Otherwise, if this is the first installation from sources, we immediately move on to the following instructions:

```bash
sudo ln --symbolic --verbose /opt/php/8.3.11/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.11/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.11/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.11/bin/php-config /usr/bin/php-config
```
