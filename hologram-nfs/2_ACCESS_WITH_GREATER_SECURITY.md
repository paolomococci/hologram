# improve security when accessing the virtual machine

## setup login from certificate

### on client

This only needs to be done if you haven't already generated a key on the client:

```bash
chmod 755 ~/.ssh
ssh-keygen -b 4096
```

Now it's time to copy the key to the remote system:

```bash
ssh-copy-id -i ~/.ssh/id_rsa.pub developer_username@192.168.1.XXX
ssh developer_username@192.168.1.XXX
```

Obviously, the name of the public key depends on the system.

### on server

```bash
su -
ls -l /etc/ssh/sshd_config
nano /etc/ssh/sshd_config
```

Edit the file so that the following settings have the values as below:

```text
HostbasedAuthentication yes
RSAAuthentication yes
PubkeyAuthentication yes
ChallengeResponseAuthentication no
PasswordAuthentication no
UsePAM no
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
    "name": "hologram-nfs",
    "username": "developer_username",
    "privateKeyPath": "/home/developer_username/.ssh/id_rsa",
    "passphrase": "developer_passphrase",
    "host": "192.168.1.XXX",
    "remotePath": "/home/developer_username",
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
