## I use a local image
FROM hologram-img:6.0

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

## conf-available
COPY ./conf/conf-available/php-fpm.conf /etc/apache2/conf-available/php-fpm.conf

## from directory of root user
WORKDIR /root
## make symbolic links to php
RUN ln --symbolic --verbose /opt/php/8.3.11/bin/php /usr/bin/php
RUN ln --symbolic --verbose /opt/php/8.3.11/bin/phar.phar /usr/bin/phar
RUN ln --symbolic --verbose /opt/php/8.3.11/bin/phpize /usr/bin/phpize
RUN ln --symbolic --verbose /opt/php/8.3.11/bin/php-config /usr/bin/php-config
## configure /opt/php/8.3.11/lib/php.ini
RUN cp sources/php-8.3.11/php.ini-development /opt/php/8.3.11/lib/php.ini
RUN sed -i 's/;date.timezone =/date.timezone = "Europe\/Rome"/g' /opt/php/8.3.11/lib/php.ini
RUN sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /opt/php/8.3.11/lib/php.ini
RUN sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /opt/php/8.3.11/lib/php.ini
RUN sed -i 's/max_execution_time = 30/max_execution_time = 100/g' /opt/php/8.3.11/lib/php.ini
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/g' /opt/php/8.3.11/lib/php.ini
RUN sed -i 's/short_open_tag = Off/short_open_tag = On/g' /opt/php/8.3.11/lib/php.ini
RUN sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.3.11/lib/php.ini
## configure /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN cp /opt/php/8.3.11/etc/php-fpm.d/www.conf.default /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN sed -i 's/^user = nobody/;user = nobody/g' /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN sed -i 's/^group = nobody/;group = nobody/g' /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN sed -i 's/^listen = 127.0.0.1:9000/;listen = 127.0.0.1:9000/g' /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN sed -i '$a; UNIX socket' /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN sed -i '$alisten = /run/php-fpm.sock' /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN sed -i '$alisten.owner = www-data' /opt/php/8.3.11/etc/php-fpm.d/www.conf
RUN sed -i '$alisten.group = www-data' /opt/php/8.3.11/etc/php-fpm.d/www.conf
## configure /opt/php/8.3.11/etc/php-fpm.conf
RUN cp /opt/php/8.3.11/etc/php-fpm.conf.default /opt/php/8.3.11/etc/php-fpm.conf
RUN sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.3.11/etc/php-fpm.conf
RUN sed -i '$auser = www-data' /opt/php/8.3.11/etc/php-fpm.conf
RUN sed -i '$agroup = www-data' /opt/php/8.3.11/etc/php-fpm.conf
## clean
RUN rm --recursive sources

## activate all necessary modules and restart the web server
RUN a2enmod proxy_fcgi
RUN a2enconf php-fpm

## default web content
COPY ./dev/landing/source/ /var/www/html

## I expose port 443 TCP
EXPOSE 443

## command written in exec form
COPY ./scripts/start.sh ./start.sh
RUN chmod 700 ./start.sh
CMD ["/bin/bash", "-c", "./start.sh"]