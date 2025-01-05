#! /bin/bash

php-fpm --nodaemonize --allow-to-run-as-root --fpm-config /opt/php/8.2.24/etc/php-fpm.conf &
apache2ctl -D FOREGROUND