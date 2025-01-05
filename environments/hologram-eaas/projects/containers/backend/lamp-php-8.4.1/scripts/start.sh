#! /bin/bash

# setup
./setup.sh

# start services
/usr/sbin/sshd -D &
php-fpm --daemonize --allow-to-run-as-root --fpm-config /opt/php/8.4.1/etc/php-fpm.conf
apache2ctl -D FOREGROUND