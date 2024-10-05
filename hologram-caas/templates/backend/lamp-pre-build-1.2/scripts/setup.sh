#! /bin/bash

# setup OpenSSH
mkdir /var/run/sshd
chmod 755 /var/run/sshd/
echo "PermitRootLogin yes" >> /etc/ssh/sshd_config

# set root password
echo "root:some_password" | chpasswd