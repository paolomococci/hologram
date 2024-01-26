# hologram-php80 clone

## clone a virtual machine hologram-php

With root credentials, if directory `domains` does not exist:

```bash
mkdir domains
```

otherwise we proceed with cloning the virtual machine:

```bash
cd ~/domains/
virsh dumpxml hologram-php > ./hologram-php80.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 /var/lib/libvirt/images/hologram-php80.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-php80.xml
```

Edit `hologram-php80.xml`:

```xml
...
<name>hologram-php80</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php80 (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.80)</title>
...
<source file='/var/lib/libvirt/images/hologram-php80.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

If you prefer, `sed` can be used, for example:

```bash
sed -i 's/hologram-php/hologram-php80/g' hologram-php80.xml
sed -i 's/192.168.1.150/192.168.1.80/g' hologram-php80.xml
```

and so on, also for the other values to be modified.

From virsh cli:

```shell
net-edit default
```

Edit:

```xml
...
<dhcp>
    <range start='192.168.1.2' end='192.168.1.254'/>
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-php80' ip='192.168.1.80'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define hologram-php80.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start hologram-php80
dominfo hologram-php80
domifaddr hologram-php80
```

### open GUI

#### into hologram-php80 edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-php80
sudo nano /etc/hosts
sudo reboot
```

#### regenerate OpenSSH Host Keys

```bash
sudo grep -ir "hologram-php" /etc
sudo rm /etc/ssh/ssh_host_*
sudo dpkg-reconfigure openssh-server
sudo reboot
```

From the virsh cli I can, among other things:

```shell
suspend hologram-php80
resume hologram-php80
save hologram-php80 hologram-php80_dump
restore hologram-php80_dump
shutdown hologram-php80
reboot hologram-php80
```
