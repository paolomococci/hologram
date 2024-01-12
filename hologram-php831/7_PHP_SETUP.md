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
