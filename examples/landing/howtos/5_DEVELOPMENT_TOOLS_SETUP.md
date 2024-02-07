# development tools and libraries

## installing some development tools that I think are almost indispensable

Therefore, if I had not previously done so, proceed with the installation and update as follows:

```bash
sudo apt install libapache2-mod-fcgid
```

`libapache2-mod-fcgid` it is necessary to use PHP-FPM.

And if I want to compile PHP from source, if not previously installed, I will need the following packages:

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

With the following command I can check if the package is already installed:

```bash
dpkg -l build-essential
```

To then proceed with installing the packages that are not yet present on the system.

As follows, for example only:

```bash
sudo apt update
sudo apt install libcurl4-openssl-dev libbz2-dev libjpeg-dev libgmp3-dev libxslt1-dev libpng-dev libsqlite3-dev libonig-dev apache2-dev libxml2-dev
```

## for pdf documents view

If you want to be able to view pdf files in the terminal, you can do the following:

```bash
sudo apt install poppler-utils
```

## update node.js and npm

If necessary, you can proceed as follows:

```bash
npm -v
node -v
nodejs -v
sudo npm cache clean -f
sudo npm install -g n
sudo n stable
sudo npm install -g npm@latest
```
