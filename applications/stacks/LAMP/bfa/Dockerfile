################################################################
## Stage 1 – Builder
################################################################
FROM lamp-dsa-img:1.0 AS builder

################################################################
## Stage 2 – Base
################################################################
FROM alpine:3.22.2 AS base

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
## 2.6 Configure the pool to listen on port 49152
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:49152/' /usr/local/etc/php-fpm.d/www.conf
################################################################

################################################################
## 2.7 Exposes the port used by php-fpm, (this is optional if you have a reverse proxy)
################################################################
EXPOSE 49152

################################################################
## 2.8 Start command
################################################################
CMD ["/usr/local/sbin/php-fpm", "-F"]