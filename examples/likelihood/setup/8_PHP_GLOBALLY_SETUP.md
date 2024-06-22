# make PHP accessible globally not just from Apache

Side note, if you don't want to continuously repeat the `sudo` command and like me in this case you need to issue numerous commands from root, the following command might be useful:

```bash
sudo -s
```

Quick warning, if the following links are already there, you will need to remove them first. To then recreate new ones that point to the newly installed versions.

```bash
rm /usr/bin/php
rm /usr/bin/phar
rm /usr/bin/phpize
rm /usr/bin/php-config
```

Otherwise, if this is the first installation from sources, we immediately move on to the following instructions:

```bash
ln --symbolic --verbose /opt/php/8.3.8/bin/php /usr/bin/php
ln --symbolic --verbose /opt/php/8.3.8/bin/phar.phar /usr/bin/phar
ln --symbolic --verbose /opt/php/8.3.8/bin/phpize /usr/bin/phpize
ln --symbolic --verbose /opt/php/8.3.8/bin/php-config /usr/bin/php-config
```

Update `locate` cache:

```bash
php -v
updatedb
exit
locate php.ini
```