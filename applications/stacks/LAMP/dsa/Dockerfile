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
