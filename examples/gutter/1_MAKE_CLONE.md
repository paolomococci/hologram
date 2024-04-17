# I create a clone for a CMS installation example

## backup of originally virtual machine with root credentials

```bash
ls -al ~/domains/
cd ~/domains/
virsh dumpxml hologram-php831xdb > ./gutter.xml
virsh domblklist hologram-php831xdb
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php831xdb.qcow2 /var/lib/libvirt/images/gutter.qcow2
```

Carry out the actual cloning:

```bash
uuidgen
~/tools/latest_three_mac_gen.py
nano gutter.xml
```

And type:

```text
...
<name>gutter</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>gutter (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.XXX)</title>
...
<source file='/var/lib/libvirt/images/gutter.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

Open a shell for the virsh cli:

```shell
net-destroy default
net-edit default
```

edit

```text
<host mac='XX:XX:XX:XX:XX:XX' name='gutter' ip='192.168.1.XXX'/>
```

From bash shell:

```bash
virsh define gutter.xml
```

Now from virsh cli:

```shell
net-start default
list --all --title
start gutter
dominfo gutter
domifaddr gutter
```

### open `Virtual Machine Manager` GUI

#### into gutter edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname gutter
sudo nano /etc/hosts
sudo reboot
```

#### regenerate OpenSSH Host Keys

```bash
sudo grep -ir "hologram-php831xdb" /etc
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
sudo du --human-readable --summarize /var/cache/apt/archives/
sudo apt-get autoclean
```

From the virsh cli I can, among other things:

```shell
suspend gutter
resume gutter
save gutter gutter_dump
restore gutter_dump
shutdown gutter
reboot gutter
```

Of course, you will need to replace the `X` with the appropriate values.
