# configure 

The settings for subsequent compilation from PHP version 8.3.1 sources.

```bash
mkdir build_session && cd build_session
../configure --prefix=/opt/php/8.3.1 --enable-fpm --enable-bcmath --enable-opcache --enable-ftp --with-openssl-dir=/usr/bin/openssl --disable-cgi --enable-mbstring --with-curl --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug
make
make test
sudo make install
```
