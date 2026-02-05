################################################################
## 1.0 Build step – install deps & compile
################################################################
FROM debian:bookworm-slim AS builder
ARG DEBIAN_FRONTEND=noninteractive
# the following can be overridden with the flag --build-arg
ARG XDEBUG_CLIENT_HOST=127.0.0.1
ENV TZ=Etc/UTC

################################################################
## 1.1 install build‑time deps
################################################################
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    git build-essential autoconf libtool bison re2c pkg-config \
    libssl-dev libcurl4-openssl-dev libbz2-dev libjpeg-dev libgmp-dev libxslt1-dev \
    libpng-dev libsqlite3-dev libonig-dev libxml2-dev libffi-dev libzip-dev libgd-dev \
    iproute2 iputils-ping openssh-server apache2 apache2-utils libapache2-mod-fcgid \
    curl nano python3-pip unzip pwgen \
    && rm -rf /var/lib/apt/lists/*

################################################################
## 1.2 copy sources
################################################################
COPY sources/ /tmp/sources
WORKDIR /tmp/sources

################################################################
## 1.3 configure and compile PHP 8.4.14
################################################################
RUN tar -xf php-8.4.14.tar.xz && \
    cd php-8.4.14 && \
    ./configure \
    --prefix=/opt/php/8.4.14 \
    --enable-fpm \
    --enable-bcmath \
    --enable-ftp \
    --with-openssl \
    --disable-cgi \
    --enable-mbstring \
    --with-curl \
    --with-mysqli \
    --with-pdo-mysql \
    --enable-intl \
    --with-zlib \
    --with-bz2 \
    --enable-gd \
    --with-jpeg \
    --with-gettext \
    --with-gmp \
    --with-xsl \
    --enable-zts \
    --enable-gcov \
    --enable-debug \
    --with-ffi \
    --with-zip \
    --enable-pcntl && \
    make -j$(nproc) && make install

################################################################
## 1.4 make symbolic links to php
################################################################
RUN ln --symbolic --verbose /opt/php/8.4.14/bin/php /usr/bin/php && \
    ln --symbolic --verbose /opt/php/8.4.14/bin/phar.phar /usr/bin/phar && \
    ln --symbolic --verbose /opt/php/8.4.14/bin/phpize /usr/bin/phpize && \
    ln --symbolic --verbose /opt/php/8.4.14/bin/php-config /usr/bin/php-config && \
    ln --symbolic --verbose /opt/php/8.4.14/sbin/php-fpm /usr/bin/php-fpm

################################################################
## 1.5 configure and compile Xdebug 3.4.6
################################################################
RUN tar -xzf xdebug-3.4.6.tgz && \
    cd xdebug-3.4.6 && \
    phpize && \
    ./configure --prefix=/opt/php/xdebug --enable-xdebug && \
    make -j$(nproc) && make install

################################################################
## 1.6 install Composer (pre‑compiled)
################################################################
COPY bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

################################################################
## 1.7 copy php.ini file
################################################################
RUN cp /tmp/sources/php-8.4.14/php.ini-development /opt/php/8.4.14/lib/php.ini

################################################################
## 1.8 cleanup build‑time deps
################################################################
RUN apt-get purge -y build-essential autoconf libtool bison re2c pkg-config && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/* /tmp/*

################################################################
## 2.0 Runtime step – minimal image
################################################################
FROM debian:bookworm-slim
ARG DEBIAN_FRONTEND=noninteractive
ARG XDEBUG_CLIENT_HOST=127.0.0.1          # can be overridden with --build-arg
ENV TZ=Etc/UTC
ENV XDEBUG_CLIENT_HOST=${XDEBUG_CLIENT_HOST}

# install only runtime libs + tini for signal forwarding
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    openssh-server iproute2 iputils-ping \
    apache2 apache2-utils libapache2-mod-fcgid \
    libssl3 openssl libcurl4-openssl-dev libbz2-1.0 libjpeg62-turbo \
    libgmp10 libxslt1.1 libpng16-16 libsqlite3-0 libonig5 \
    libxml2 libffi8 libzip4 libgd-dev tini pwgen \
    && rm -rf /var/lib/apt/lists/*

# generate host keys if missing
RUN ssh-keygen -A

################################################################
## 2.1 setup of PHP artifacts
################################################################
COPY --from=builder /opt/php /opt/php
RUN ln -s /opt/php/8.4.14/bin/php /usr/bin/php && \
    ln -s /opt/php/8.4.14/bin/phar.phar /usr/bin/phar && \
    ln -s /opt/php/8.4.14/bin/phpize /usr/bin/phpize && \
    ln -s /opt/php/8.4.14/bin/php-config /usr/bin/php-config && \
    ln -s /opt/php/8.4.14/sbin/php-fpm /usr/bin/php-fpm

################################################################
## 2.2 configure /opt/php/8.4.14/lib/configure php.ini
################################################################
RUN sed -i 's/;date.timezone =/date.timezone = "Europe\/Rome"/' /opt/php/8.4.14/lib/php.ini && \
    sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/' /opt/php/8.4.14/lib/php.ini && \
    sed -i 's/memory_limit = 128M/memory_limit = 256M/' /opt/php/8.4.14/lib/php.ini && \
    sed -i 's/max_execution_time = 30/max_execution_time = 100/' /opt/php/8.4.14/lib/php.ini && \
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 8M/' /opt/php/8.4.14/lib/php.ini && \
    sed -i 's/short_open_tag = Off/short_open_tag = On/' /opt/php/8.4.14/lib/php.ini && \
    sed -i 's/;zend_extension=opcache/zend_extension=opcache.so/g' /opt/php/8.4.14/lib/php.ini

################################################################
## 2.3 configure /opt/php/8.4.14/etc/php-fpm.d/www.conf
################################################################
RUN cp /opt/php/8.4.14/etc/php-fpm.d/www.conf.default /opt/php/8.4.14/etc/php-fpm.d/www.conf && \
    sed -i 's/^user = nobody/;user = nobody/g' /opt/php/8.4.14/etc/php-fpm.d/www.conf && \
    sed -i 's/^group = nobody/;group = nobody/g' /opt/php/8.4.14/etc/php-fpm.d/www.conf && \
    sed -i 's/^listen = 127.0.0.1:9000/;listen = 127.0.0.1:9000/g' /opt/php/8.4.14/etc/php-fpm.d/www.conf && \
    sed -i '$a; UNIX socket' /opt/php/8.4.14/etc/php-fpm.d/www.conf && \
    sed -i '$alisten = /run/php-fpm.sock' /opt/php/8.4.14/etc/php-fpm.d/www.conf && \
    sed -i '$alisten.owner = www-data' /opt/php/8.4.14/etc/php-fpm.d/www.conf && \
    sed -i '$alisten.group = www-data' /opt/php/8.4.14/etc/php-fpm.d/www.conf

################################################################
## 2.4 configure /opt/php/8.4.14/etc/php-fpm.conf
################################################################
RUN cp /opt/php/8.4.14/etc/php-fpm.conf.default /opt/php/8.4.14/etc/php-fpm.conf && \
    sed -i 's/;pid = run\/php-fpm.pid/pid = run\/php-fpm.pid/g' /opt/php/8.4.14/etc/php-fpm.conf && \
    sed -i '$auser = www-data' /opt/php/8.4.14/etc/php-fpm.conf && \
    sed -i '$agroup = www-data' /opt/php/8.4.14/etc/php-fpm.conf

################################################################
## 2.5 configure Xdebug on /opt/php/8.4.14/lib/php.ini
################################################################
RUN echo 'zend_extension=xdebug' >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.mode=develop,debug,trace,coverage' >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.cli_color=1' >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.start_with_request=trigger' >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.discover_client_host=1' >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.mode=debug' >> /opt/php/8.4.14/lib/php.ini && \
    echo "xdebug.client_host=${XDEBUG_CLIENT_HOST:-127.0.0.1}" >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.client_port=9003' >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.connect_timeout_ms=2000' >> /opt/php/8.4.14/lib/php.ini && \
    echo 'xdebug.idekey=VSCODE' >> /opt/php/8.4.14/lib/php.ini

################################################################
## 2.6 set Apache configuration
################################################################
RUN mkdir -p /etc/ssl/self_signed_certs && chmod 0755 /etc/ssl/self_signed_certs

################################################################
## 2.7 copy self signed certificate
################################################################
COPY ./conf/self-signed-certificates/ /etc/ssl/self_signed_certs
RUN chmod 600 /etc/ssl/self_signed_certs/vanilla* && \
    chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh

################################################################
## 2.8 configure ServerName
################################################################
RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf && \
    echo "SSLPassPhraseDialog exec:/etc/ssl/self_signed_certs/echo_passphrase.sh" >> /etc/apache2/apache2.conf

################################################################
## 2.9 copy sites-available configurations
################################################################
COPY ./conf/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./conf/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

################################################################
## 2.10 copy conf-available
################################################################
COPY ./conf/conf-available/php-fpm.conf /etc/apache2/conf-available/php-fpm.conf

################################################################
## 2.11 copy mods-available
################################################################
COPY ./conf/mods-available/dir.conf /etc/apache2/mods-available/dir.conf

################################################################
## 2.12 enable modules and configurations
################################################################
RUN a2enmod proxy_fcgi ssl rewrite headers && a2enconf php-fpm

################################################################
## 2.13 enable the VirtualHost TSL
################################################################
RUN a2ensite default-ssl.conf

################################################################
## 2.14  copy Composer
################################################################
COPY --from=builder /usr/local/bin/composer /usr/local/bin/composer

################################################################
## 2.15 volume & ports
################################################################
VOLUME ["/var/www/html"]
EXPOSE 80 22 443 9003

################################################################
## 2.16 scripts
################################################################
COPY scripts /usr/local/bin
RUN chmod +x /usr/local/bin/setup.sh /usr/local/bin/start.sh

################################################################
## 2.17 set root password from environment var
################################################################
ARG ROOT_PASSWORD
ENV ROOT_PASSWORD=${ROOT_PASSWORD}

################################################################
## 2.18 entry point
################################################################
# tini forwards signals, start.sh is the foreground process
ENTRYPOINT ["tini","--"]
CMD ["/usr/local/bin/start.sh"]