# add support of Xdebug

## make PHP accessible globally not just from Apache

```bash
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/php-config /usr/bin/php-config
```

Update `locate` cache:

```bash
sudo updatedb
locate php.ini
```
