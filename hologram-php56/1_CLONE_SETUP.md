# clone setup

I will try to exemplify as much as possible the procedure for cloning a KVM based virtual machine.
The host system is GNU/Linux Debian 12.
I have previously prepared a virtual machine called hologram-php, a LAMP stack which only needs to define the PHP version.

## clone a virtual machine hologram-php

With root credentials:

```bash
mkdir ~/vmdumps/hologram-php/
cd ~/vmdumps/hologram-php/
virsh dumpxml hologram-php > ./hologram-php.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 ./hologram-php.qcow2
```

### prepare hologram-php56

Now I will generate a new UUID and the last three digits of a dummy MAC address, the first three will be taken from the cloned virtual machine.

```bash
cd ~
uuidgen
tools/latest_three_mac_gen.py
```

Having written down the generated values somewhere, proceed with the following commands:

```bash
cp vmdumps/hologram-php/hologram-php.qcow2 /var/lib/libvirt/images/hologram-php56.qcow2
cp vmdumps/hologram-php/hologram-php.xml hologram-php56.xml
nano vmdumps/hologram-php/hologram-php56.xml
```

And edit the following lines:

```xml
...
<name>hologram-php56</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php56 (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.56)</title>
...
<source file='/var/lib/libvirt/images/hologram-php56.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

From virsh cli

```shell
net-edit default
```

Edit:

```text
...
<dhcp>
    <range start='192.168.1.2' end='192.168.1.254'/>
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-php56' ip='192.168.1.56'/>
</dhcp>
...
```

From bash shell with root credentials:

```bash
virsh define vmdumps/hologram-php/hologram-php56.xml
```

And from virsh cli:

```shell
list --all --title
net-start default
start hologram-php56
list --all --title
dominfo hologram-php56
domifaddr hologram-php56
```

## open GUI of `Virtual Machine Manager`

From the list of virtual machines I select hologram-php56, open it and login from the terminal.

### into hologram-php56 edit setting files linked to the hostname

basically I'm going to add the number `56`to the string `hologram-php`

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

Or:

```bash
sudo hostnamectl set-hostname hologram-php56
sudo nano /etc/hosts
sudo reboot
```

### regenerate OpenSSH Host Keys

I login again:

```bash
sudo grep -ir "hologram-php" /etc
sudo rm /etc/ssh/ssh_host_*
sudo dpkg-reconfigure openssh-server
sudo reboot
```
