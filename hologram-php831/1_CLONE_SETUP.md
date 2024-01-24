# hologram-php831 clone

## clone a virtual machine hologram-php

with root credentials:

```bash
ls -al ~/vmdumps/backup/
mkdir ~/vmdumps/backup/hologram-php/ && cd ~/vmdumps/backup/hologram-php/
virsh dumpxml hologram-php > ./hologram-php831.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 /var/lib/libvirt/images/hologram-php831.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-php831.xml
```

Edit `hologram-php831.xml`:

```xml
...
<name>hologram-php831</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php831 (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.12)</title>
...
<source file='/var/lib/libvirt/images/hologram-php831.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

From virsh cli:

```shell
net-edit default
```

Edit:

```xml
...
<dhcp>
    <range start='192.168.1.2' end='192.168.1.254'/>
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-php831' ip='192.168.1.12'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define hologram-php831.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start hologram-php831
dominfo hologram-php831
domifaddr hologram-php831
```

### open GUI

#### into hologram-php831 edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-php831
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
suspend hologram-php831
resume hologram-php831
save hologram-php831 hologram-php831_dump
restore hologram-php831_dump
shutdown hologram-php831
reboot hologram-php831
```
