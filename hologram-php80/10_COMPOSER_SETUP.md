# Composer setups

First, however, it is necessary to make PHP 8.3.2 also usable from the command line.

## I remove the links to PHP 8.0.30

```bash
sudo rm /usr/bin/php
sudo rm /usr/bin/phar
sudo rm /usr/bin/phpize
sudo rm /usr/bin/php-config
```

## I make PHP 8.3.2 accessible globally not just from Apache

```bash
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/php-config /usr/bin/php-config
```

I issued the following commands:

```bash
mkdir composer && cd composer
```

And after following the instructions listed on the official Composer website I performed the actual global installation:

```bash
whereis php
sudo cp composer.phar /usr/bin/composer
composer list
```
