## I use a local image
FROM hologram-img:4.0

## user
USER root

## self-signed-certificates
RUN mkdir -p /etc/ssl/self_signed_certs
COPY ./conf/self-signed-certificates /etc/ssl/self_signed_certs
RUN chmod 600 /etc/ssl/self_signed_certs/hologram*
RUN chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh

## mods-available and sites-available configurations
COPY ./conf/mods-available/dir.conf /etc/apache2/mods-available/dir.conf
COPY ./conf/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./conf/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

## I compile and install the PHP programming language from source
RUN mkdir -p /root/sources
COPY ./sources/ /root/sources
WORKDIR /root/sources/php-8.3.11
RUN chmod 755 ./configure
RUN mkdir build-php
WORKDIR /root/sources/php-8.3.11/build-php
RUN ../configure --prefix=/opt/php/8.3.11 --enable-fpm --enable-bcmath --enable-ftp --with-openssl --disable-cgi --enable-mbstring --with-curl --with-mysqli --with-pdo-mysql --enable-intl --with-zlib --with-bz2 --enable-gd --with-jpeg --with-gettext --with-gmp --with-xsl --enable-zts --enable-gcov --enable-debug --with-ffi
RUN mkdir -p ext/opcache
RUN make && make install

## activate all necessary modules and restart the web server
WORKDIR /root
RUN service apache2 restart

## default web content
COPY ./dev/landing/dist/ /var/www/html

## I expose port 443 TCP
EXPOSE 443

## command written in exec form
CMD ["apache2ctl", "-D", "FOREGROUND"]