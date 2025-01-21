# development tools and libraries

## installing some development tools that I think are almost indispensable

Therefore, if I had not previously done so, proceed with the installation and update as follows:

```bash
su -
dnf check-update --refresh
dnf search mod_fcgid
dnf install mod_fcgid
```

`mod_fcgid` it is necessary to use PHP-FPM.

I once made sure `gcc` is not already installed:

```bash
dnf list available | grep "gcc"
dnf list installed | grep "gcc"
```

I proceed with the installation of `make`, `LLVM` and `clang`:

```bash
dnf list available | grep "llvm"
dnf list available | grep "clang"
dnf install llvm-devel clang-devel make-latest
dnf install llvm-toolset clang-tools-extra python3-clang python3.12-devel python3.12-pip
```

And more is needed to compile PHP:

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
* openssl-devel
* autoconf

To then proceed with installing the packages that are not yet present on the system.

As follows, for example only:

```bash
dnf install libxml2-devel sqlite-devel bzip2-devel libcurl-devel libffi-devel libpng-devel libjpeg-turbo-devel gmp-devel libicu-devel oniguruma-devel libxslt-devel libzip libzip-tools libzip-devel openssl-devel autoconf
```
