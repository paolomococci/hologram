# development tools and libraries

## installing some development tools that I think are almost indispensable

Therefore, if I had not previously done so, proceed with the installation and update as follows:

```bash
su -
dnf search mod_fcgid
dnf install mod_fcgid
```

`mod_fcgid` it is necessary to use PHP-FPM.

And more:

* libxml2-devel
* sqlite-devel
* bzip2-devel
* libcurl-devel
* libffi-devel
* libpng-devel
* libjpeg-turbo-devel
* gmp-devel
* libicu-devel
* oniguruma-devel
* libxslt-devel
* libzip
* libzip-tools
* libzip-devel

To then proceed with installing the packages that are not yet present on the system.

As follows, for example only:

```bash
dnf check-update --refresh
dnf libxml2-devel sqlite-devel bzip2-devel libcurl-devel libffi-devel libpng-devel libjpeg-turbo-devel gmp-devel libicu-devel oniguruma-devel libxslt-devel libzip libzip-tools libzip-devel
```
