################################################################
## Stage 1 – Build
################################################################
# Use Alpine Linux to reduce image size
FROM alpine:3.22.2 AS builder

################################################################
## 1.1 Build‑time dependencies
################################################################
RUN apk add --no-cache \
    build-base \
    wget \
    openssl-dev \
    pcre2-dev \
    libxml2-dev \
    curl-dev \
    zlib-dev \
    libedit-dev \
    libuuid \
    bzip2-dev \
    sqlite-dev \
    libzip-dev \
    libffi-dev \
    libpng-dev \
    libjpeg \
    libjpeg-turbo-dev \
    gettext-dev \
    gmp-dev \
    icu-dev \
    oniguruma-dev \
    libxslt-dev \
    unzip \
    autoconf \
    bison \
    re2c

################################################################
## 1.2 Copy sources
################################################################
COPY sources/ /tmp/sources
WORKDIR /tmp/sources

################################################################
## 1.3 Extract PHP 8.5.0beta3
################################################################
RUN unzip php-src-php-8.5.0beta3.zip

################################################################
## 1.4 Generate the configuration file
################################################################
WORKDIR /tmp/sources/php-src-php-8.5.0beta3
RUN ./buildconf --force

################################################################
## 1.5 Configure PHP 8.5.0beta3
################################################################
RUN ./configure \
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
    --with-ffi \
    --with-zip \
    --enable-pcntl \
    --disable-phpdbg \
    --disable-debug \
    --disable-rpath && \
    make -j$(nproc) && \
    make install

################################################################
## Stage 2 – Runtime
################################################################
FROM alpine:3.22.2

################################################################
## 2.1 Required runtime libraries for php-fpm
################################################################
RUN apk add --no-cache \
    openssl \
    pcre2 \
    libxml2 \
    zlib \
    curl \
    libedit \
    libuuid \
    libbz2 \
    libzip \
    oniguruma \
    libxslt \
    libjpeg-turbo \
    libpng \
    libwebp \
    libexif \
    icu-libs \
    gmp \
    sqlite-libs \
    libstdc++ \
    libgcc \
    gd \
    gettext-libs \
    libffi \
    bzip2

################################################################
## 2.2 Copy binaries and libraries from the builder
################################################################
COPY --from=builder /usr/local/sbin/php-fpm /usr/local/sbin/php-fpm
COPY --from=builder /usr/local/lib/php /usr/local/lib/php
COPY --from=builder /tmp/sources/php-src-php-8.5.0beta3/php.ini-development /usr/local/etc/php/php.ini
COPY --from=builder /usr/local/etc/php-fpm.conf.default /usr/local/etc/php-fpm.conf
COPY --from=builder /usr/local/etc/php-fpm.d/www.conf.default /usr/local/etc/php-fpm.d/www.conf

################################################################
## 2.3 Set the configurations correctly
################################################################
RUN sed -i '$c\include=/usr/local/etc/php-fpm.d/*.conf' /usr/local/etc/php-fpm.conf

################################################################
## 2.4 Set logs to stderr
################################################################
RUN sed -i 's|^;error_log = .*|error_log = /proc/self/fd/2|' /usr/local/etc/php-fpm.conf

################################################################
## 2.5 Adds the application or RESTful API
################################################################
WORKDIR /app
COPY src/ .

################################################################
## 2.6 Configure the pool to listen on port 9000
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf
################################################################

################################################################
## 2.7 Exposes the port used by php-fpm, (this is optional if you have a reverse proxy)
################################################################
EXPOSE 9000

################################################################
## 2.8 Start command
################################################################
CMD ["/usr/local/sbin/php-fpm", "-F"]