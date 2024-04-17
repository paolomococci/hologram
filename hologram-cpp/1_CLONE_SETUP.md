# hologram-cpp clone

## clone a virtual machine hologram-php

With root credentials, if directory `domains` does not exist:

```bash
mkdir domains
```

otherwise we proceed with cloning the virtual machine:

```bash
cd ~/domains/
virsh dumpxml hologram-php > ./hologram-cpp.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 /var/lib/libvirt/images/hologram-cpp.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-cpp.xml
```

Edit `hologram-cpp.xml`:

```xml
...
<name>hologram-cpp</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-cpp (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.123)</title>
...
<source file='/var/lib/libvirt/images/hologram-cpp.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

If you prefer, `sed` can be used, for example:

```bash
sed -i 's/hologram-php/hologram-cpp/g' hologram-cpp.xml
sed -i 's/192.168.1.150/192.168.1.123/g' hologram-cpp.xml
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
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-cpp' ip='192.168.1.123'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define hologram-cpp.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start hologram-cpp
dominfo hologram-cpp
domifaddr hologram-cpp
```

### open GUI

#### into hologram-cpp edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-cpp
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
suspend hologram-cpp
resume hologram-cpp
save hologram-cpp hologram-cpp_dump
restore hologram-cpp_dump
shutdown hologram-cpp
reboot hologram-cpp
```
