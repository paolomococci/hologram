#! /bin/bash

php-fpm --nodaemonize --allow-to-run-as-root --fpm-config /opt/php/7.4.33/etc/php-fpm.conf &
apache2ctl -D FOREGROUND