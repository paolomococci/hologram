# development tools and libraries

## installing some development tools that I think are almost indispensable

If I want to compile PHP from source, if not previously installed, I will need the following packages:

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

With the following command I can check if the package is already installed:

```bash
dpkg -l build-essential
```

To then proceed with installing the packages that are not yet present on the system.

As follows, for example only:

```bash
sudo apt update
sudo apt install build-essential autoconf libtool bison re2c pkg-config libssl-dev libcurl4-openssl-dev libbz2-dev libjpeg-dev libgmp3-dev libxslt1-dev libpng-dev libsqlite3-dev libonig-dev apache2-dev libxml2-dev libffi-dev
```
