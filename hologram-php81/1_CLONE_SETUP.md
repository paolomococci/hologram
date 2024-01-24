# hologram-php81 clone

## clone a virtual machine hologram-php

With root credentials, if directory `domains` does not exist:

```bash
mkdir domains
```

otherwise we proceed with cloning the virtual machine:

```bash
cd ~/domains/
virsh dumpxml hologram-php > ./hologram-php81.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 /var/lib/libvirt/images/hologram-php81.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-php81.xml
```

Edit `hologram-php81.xml`:

```xml
...
<name>hologram-php81</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php81 (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.81)</title>
...
<source file='/var/lib/libvirt/images/hologram-php81.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

If you prefer, `sed` can be used, for example:

```bash
sed -i 's/hologram-php/hologram-php81/g' hologram-php81.xml
sed -i 's/192.168.1.150/192.168.1.81/g' hologram-php81.xml
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
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-php81' ip='192.168.1.81'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define hologram-php81.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start hologram-php81
dominfo hologram-php81
domifaddr hologram-php81
```

### open GUI

#### into hologram-php81 edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-php81
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
suspend hologram-php81
resume hologram-php81
save hologram-php81 hologram-php81_dump
restore hologram-php81_dump
shutdown hologram-php81
reboot hologram-php81
```
