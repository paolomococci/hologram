# hologram-php74 clone

## clone a virtual machine hologram-php

With root credentials, if directory `domains` does not exist:

```bash
mkdir domains
```

otherwise we proceed with cloning the virtual machine:

```bash
cd ~/domains/
virsh dumpxml hologram-php > ./hologram-php74.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 /var/lib/libvirt/images/hologram-php74.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-php74.xml
```

Edit `hologram-php74.xml`:

```xml
...
<name>hologram-php74</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php74 (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.74)</title>
...
<source file='/var/lib/libvirt/images/hologram-php74.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

If you prefer, `sed` can be used, for example:

```bash
sed -i 's/hologram-php/hologram-php74/g' hologram-php74.xml
sed -i 's/192.168.1.150/192.168.1.74/g' hologram-php74.xml
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
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-php74' ip='192.168.1.74'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define hologram-php74.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start hologram-php74
dominfo hologram-php74
domifaddr hologram-php74
```

### open GUI

#### into hologram-php74 edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-php74
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
suspend hologram-php74
resume hologram-php74
save hologram-php74 hologram-php74_dump
restore hologram-php74_dump
shutdown hologram-php74
reboot hologram-php74
```
