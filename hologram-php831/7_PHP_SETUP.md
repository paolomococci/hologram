# Apache 2 and PHP 8.3.1

Below we will explain the steps necessary to ensure that the Apache 2 web server uses PHP-FPM (FastCGI Process Manager) compiled from sources.

## download PHP 8.3.1

```bash
cd ~
mkdir php && cd php
wget https://www.php.net/distributions/php-8.3.1.tar.bz2
ls -al
sha256sum php-8.3.1.tar.bz2
tar -xvjf php-8.3.1.tar.bz2
ls -al
cd php-8.3.1/
```
