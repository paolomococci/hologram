# hologram-php82 clone

## clone a virtual machine hologram-php

With root credentials, if directory `domains` does not exist:

```bash
mkdir domains
```

otherwise we proceed with cloning the virtual machine:

```bash
cd ~/domains/
virsh dumpxml hologram-php > ./hologram-php82.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 /var/lib/libvirt/images/hologram-php82.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-php82.xml
```

Edit `hologram-php82.xml`:

```xml
...
<name>hologram-php82</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php82 (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.82)</title>
...
<source file='/var/lib/libvirt/images/hologram-php82.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

If you prefer, `sed` can be used, for example:

```bash
sed -i 's/hologram-php/hologram-php82/g' hologram-php82.xml
sed -i 's/192.168.1.150/192.168.1.82/g' hologram-php82.xml
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
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-php82' ip='192.168.1.82'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define hologram-php82.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start hologram-php82
dominfo hologram-php82
domifaddr hologram-php82
```

### open GUI

#### into hologram-php82 edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-php82
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

Below are some useful commands for maintaining the system:

```bash
sudo apt update
sudo apt list --upgradable
sudo apt upgrade
sudo apt autoremove
sudo du -sh /var/cache/apt/archives/
sudo apt-get autoclean
```

From the virsh cli I can, among other things:

```shell
suspend hologram-php82
resume hologram-php82
save hologram-php82 hologram-php82_dump
restore hologram-php82_dump
shutdown hologram-php82
reboot hologram-php82
```
