## I use a previously created local image
FROM lamp-pre-build-img:1.2

## self-signed-certificates
COPY ./conf/self-signed-certificates /etc/ssl/self_signed_certs
RUN chmod 600 /etc/ssl/self_signed_certs/hologram*
RUN chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh

## sites-available configurations
COPY ./conf/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./conf/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

## conf-available
COPY ./conf/conf-available/php-fpm.conf /etc/apache2/conf-available/php-fpm.conf

## I copy the sources into the dedicated directory
RUN mkdir -p /root/sources
COPY ./sources/ /root/sources
## I compile and install the PHP programming language version 8.3.12 from source
WORKDIR /root/sources
RUN tar -xf php-8.3.12.tar.xz
WORKDIR /root/sources/php-8.3.12
RUN chmod 755 ./configure
RUN mkdir build-php
WORKDIR /root/sources/php-8.3.12/build-php
RUN ../configure --prefix=/opt/php/8.3.12 --enable-fpm --enable-bcmath --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug --with-ffi
RUN mkdir -p ext/opcache
RUN make && make install

## I configure PHP 8.3.12
WORKDIR /root
## make symbolic links to php
RUN ln --symbolic --verbose /opt/php/8.3.12/bin/php /usr/bin/php
RUN ln --symbolic --verbose /opt/php/8.3.12/bin/phar.phar /usr/bin/phar
RUN ln --symbolic --verbose /opt/php/8.3.12/bin/phpize /usr/bin/phpize
RUN ln --symbolic --verbose /opt/php/8.3.12/bin/php-config /usr/bin/php-config
RUN ln --symbolic --verbose /opt/php/8.3.12/sbin/php-fpm /usr/bin/php-fpm
## configure /opt/php/8.3.12/lib/php.ini
RUN cp sources/php-8.3.12/php.ini-development /opt/php/8.3.12/lib/php.ini
RUN sed -i 's/;date.timezone =/date.timezone = "Europe\/Rome"/g' /opt/php/8.3.12/lib/php.ini
RUN sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /opt/php/8.3.12/lib/php.ini
RUN sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /opt/php/8.3.12/lib/php.ini
RUN sed -i 's/max_execution_time = 30/max_execution_time = 100/g' /opt/php/8.3.12/lib/php.ini
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/g' /opt/php/8.3.12/lib/php.ini
RUN sed -i 's/short_open_tag = Off/short_open_tag = On/g' /opt/php/8.3.12/lib/php.ini
RUN sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.3.12/lib/php.ini
## configure /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN cp /opt/php/8.3.12/etc/php-fpm.d/www.conf.default /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN sed -i 's/^user = nobody/;user = nobody/g' /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN sed -i 's/^group = nobody/;group = nobody/g' /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN sed -i 's/^listen = 127.0.0.1:9000/;listen = 127.0.0.1:9000/g' /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN sed -i '$a; UNIX socket' /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN sed -i '$alisten = /run/php-fpm.sock' /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN sed -i '$alisten.owner = www-data' /opt/php/8.3.12/etc/php-fpm.d/www.conf
RUN sed -i '$alisten.group = www-data' /opt/php/8.3.12/etc/php-fpm.d/www.conf
## configure /opt/php/8.3.12/etc/php-fpm.conf
RUN cp /opt/php/8.3.12/etc/php-fpm.conf.default /opt/php/8.3.12/etc/php-fpm.conf
RUN sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.3.12/etc/php-fpm.conf
RUN sed -i '$auser = www-data' /opt/php/8.3.12/etc/php-fpm.conf
RUN sed -i '$agroup = www-data' /opt/php/8.3.12/etc/php-fpm.conf

## I compile and install Xdebug version 3.3.2
WORKDIR /root/sources
RUN tar -xzf xdebug-3.3.2.tgz
WORKDIR /root/sources/xdebug-3.3.2
RUN phpize
RUN chmod 755 ./configure
RUN mkdir build-xdebug
WORKDIR /root/sources/xdebug-3.3.2/build-xdebug
RUN ../configure --prefix=/opt/php/xdebug --enable-xdebug
RUN make && make install

## I configure Xdebug 3.3.2
WORKDIR /root
RUN sed -i '$azend_extension=xdebug' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.mode=develop,debug,trace' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.cli_color=1' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.start_with_request=trigger' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.discover_client_host=1' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.remote_enable=1' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.client_host=192.168.122.1' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.client_port=9003' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.connect_timeout_ms=2000' /opt/php/8.3.12/lib/php.ini
RUN sed -i '$axdebug.idekey=VSCODE' /opt/php/8.3.12/lib/php.ini

## I'm doing a little cleaning
RUN rm --recursive sources

## activate all necessary modules and restart the web server
RUN a2enmod proxy_fcgi
RUN a2enconf php-fpm

## volume of web content
VOLUME ["/var/www/html"]

## I expose ports 22, 443 and 9003
## Port 80 is opened by default
EXPOSE 22 443 9003

## I copy and run the scripts with the commands
COPY ./scripts .
RUN chmod 700 ./setup.sh
RUN chmod 700 ./start.sh
CMD ["/bin/bash", "-c", "./start.sh"]