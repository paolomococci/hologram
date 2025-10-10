#! /bin/bash

# Xdebug client host
if [[ -n "${XDEBUG_CLIENT_HOST:-}" ]]; then
    sed -i "s/^xdebug.client_host=.*/xdebug.client_host=${XDEBUG_CLIENT_HOST}/" \
        /opt/php/8.4.13/lib/php.ini
fi

# setup OpenSSH
mkdir /var/run/sshd
chmod 755 /var/run/sshd/
echo "PermitRootLogin yes" >> /etc/ssh/sshd_config

# set root password: `pwgen -s 16 1` or `pwgen -s 20 1`
if [[ -n "${ROOT_PASSWORD:-}" ]]; then
    echo "root:${ROOT_PASSWORD}" | chpasswd
else
    # generates a secure sixteen-character password
    ROOT_PASSWORD=$(pwgen -s 16 1)

    # set the password for the root user
    echo "root:${ROOT_PASSWORD}" | chpasswd

    # optional, show the generated password
    echo "Root password generated: ${ROOT_PASSWORD}"
fi