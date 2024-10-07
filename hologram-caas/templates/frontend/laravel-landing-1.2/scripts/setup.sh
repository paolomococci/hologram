#! /bin/bash

# setup OpenSSH
mkdir /var/run/sshd
chmod 755 /var/run/sshd/
echo "PermitRootLogin yes" >> /etc/ssh/sshd_config

# set root password: `pwgen -s 16 1` or `pwgen -s 20 1`
echo "root:some_password" | chpasswd