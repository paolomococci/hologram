# development tools and libraries setup

I will need the following packages:

* build-essential
* autoconf
* libtool
* bison
* re2c
* pkg-config 
* libssl-dev 
* libcurl4-openssl-dev
* libbz2-dev
* libjpeg-dev 
* libgmp3-dev 
* libxslt1-dev 
* libpng-dev 
* libsqlite3-dev 
* libonig-dev 
* apache2-dev
* libxml2-dev
* libffi-dev
* libreadline-dev
* python3
* python3-pip

With the following command I can check if the package is already installed:

```bash
dpkg -l build-essential autoconf libtool bison re2c pkg-config libssl-dev libcurl4-openssl-dev libbz2-dev libjpeg-dev libgmp3-dev libxslt1-dev libpng-dev libsqlite3-dev libonig-dev apache2-dev libxml2-dev libffi-dev libreadline-dev python3 python3-pip
```

To then proceed with installing the packages that are not yet present on the system.

As follows, for example only:

```bash
apt update  
apt install autoconf libtool bison re2c pkg-config libssl-dev libcurl4-openssl-dev libbz2-dev libjpeg-dev libgmp3-dev libxslt1-dev libpng-dev libsqlite3-dev libonig-dev apache2-dev libxml2-dev libffi-dev libreadline-dev
```
