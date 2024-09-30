#! /bin/bash

php-fpm --nodaemonize --allow-to-run-as-root --fpm-config /opt/php/8.3.12/etc/php-fpm.conf &
apache2ctl -D FOREGROUND