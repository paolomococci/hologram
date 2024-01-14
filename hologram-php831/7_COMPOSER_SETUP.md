# Composer setup

If you want to add support to Composer, dependency manager for PHP, it is best to follow the instructions offered on the official website under the heading `download`.

First, however, it is necessary to make PHP also usable from the command line.

## make PHP accessible globally not just from Apache

```bash
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/php-config /usr/bin/php-config
```
