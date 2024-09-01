# access setup

## setup login from certificate

### on client

This only needs to be done if you haven't already generated a key on the client:

```bash
chmod 755 ~/.ssh
ssh-keygen -b 4096
```

Now it's time to copy the key to the remote system:

```bash
ls -l ~/.ssh/
ssh-copy-id -i ~/.ssh/id_rsa.pub developer_username@192.168.1.XXX
ssh developer_username@192.168.1.XXX
```

I need to replace `id_rsa.pub` with the most appropriate file name found in the directory `~/.ssh/`.

### on server

```bash
perl --help
sudo -s
perl -pi -e 's/^#HostbasedAuthentication no/HostbasedAuthentication yes/' /etc/ssh/sshd_config
perl -pi -e 's/^#PubkeyAuthentication yes/PubkeyAuthentication yes/' /etc/ssh/sshd_config
perl -pi -e 's/^#PasswordAuthentication yes/PasswordAuthentication no/' /etc/ssh/sshd_config
perl -pi -e 's/^UsePAM yes/UsePAM no/' /etc/ssh/sshd_config
echo "RSAAuthentication yes" >> /etc/ssh/sshd_config
echo "ChallengeResponseAuthentication no" >> /etc/ssh/sshd_config
```

Now it's time to restart the ssh service:

```bash
/etc/init.d/ssh restart
reboot
```

## on client setup of vscode

Edit sftp.json like this:

```json
{
    "$schema": "http://json-schema.org/draft-07/schema",
    "name": "quotes",
    "username": "developer_username",
    "privateKeyPath": "/home/developer_username/.ssh/id_rsa",
    "passphrase": "developer_passphrase",
    "host": "192.168.1.XXX",
    "remotePath": "/var/www/html",
    "port": 22,
    "connectTimeout": 20000,
    "uploadOnSave": true,
    "watcher": {
        "files": "dist/*.{js,css}",
        "autoUpload": false,
        "autoDelete": false
    },
    "syncOption": {
        "delete": true,
        "update": false
    },
    "ignore": [
        ".vscode",
        ".howto",
        ".git",
        ".DS_Store",
        "TEMP",
        "nbproject",
        "probe.http"
    ]
}
```

Finally, it is important to remember that vscode can allow access and modification of the code not only with SFTP, thanks to a password or a certificate, but also in SSH. Perhaps, even more interestingly, there is also the possibility of using a bare repository by installing git on the virtual server dedicated first to the development and then to the production of the desired service.
