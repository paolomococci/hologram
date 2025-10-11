#! /bin/bash

# setup
/usr/local/bin/setup.sh

# start services
/usr/sbin/sshd -D &
# attention, the correctness of the path shown in the following line is of fundamental importance
php-fpm --nodaemonize --allow-to-run-as-root --fpm-config /opt/php/8.4.13/etc/php-fpm.conf &
apache2ctl -D FOREGROUND