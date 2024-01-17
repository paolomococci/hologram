# steps necessary for CMS setup

1. I add support to `mysqli`:

It is necessary to recompile from source PHP because WordPress require the `mysqli` PHP extension is installed and enabled:

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

I check and reload the `php-fpm` service:

```bash
sudo systemctl reload php-fpm
sudo systemctl status php-fpm --no-pager
```
