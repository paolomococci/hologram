#! /bin/bash

php-fpm --nodaemonize --allow-to-run-as-root --fpm-config /opt/php/8.1.30/etc/php-fpm.conf &
apache2ctl -D FOREGROUND