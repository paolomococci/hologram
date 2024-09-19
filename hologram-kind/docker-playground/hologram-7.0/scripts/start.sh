#! /bin/bash

/opt/php/8.3.11/sbin/php-fpm --nodaemonize --allow-to-run-as-root --fpm-config /opt/php/8.3.11/etc/php-fpm.conf &
apache2ctl -D FOREGROUND