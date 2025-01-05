#! /bin/bash

# setup
./setup.sh

# start services
/usr/sbin/sshd -D &
apache2ctl -D FOREGROUND