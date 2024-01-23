# Xdebug setup

First, however, it is necessary to make PHP also usable from the command line.

## make PHP accessible globally not just from Apache

```bash
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/php-config /usr/bin/php-config
```

Update `locate` cache:

```bash
sudo updatedb
locate php.ini
```

Side note, if you don't want to continuously repeat the `sudo` command and like me in this case you need to issue numerous commands from root, the following command might be useful:

```bash
sudo -s
```
