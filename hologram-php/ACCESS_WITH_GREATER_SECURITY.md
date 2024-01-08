# improve security when accessing the virtual machine

## setup login from certificate

### on client

```bash
chmod 755 ~/.ssh
ssh-keygen -b 4096
ssh-copy-id -i ~/.ssh/id_rsa.pub developer_username@192.168.1.XXX
ssh developer_username@192.168.1.XXX
```

### on server

```bash
sudo nano /etc/ssh/sshd_config
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
sudo /etc/init.d/ssh restart
sudo reboot
```
