# I create a clone for a CMS installation example

## backup of originally virtual machine with root credentials

```bash
ls -al ~/vmdumps/
cd ~/vmdumps/
virsh dumpxml hologram-php831 > ./hologram-wp.xml
virsh domblklist hologram-php831
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php831.qcow2 /var/lib/libvirt/images/hologram-wp.qcow2
```

Carry out the actual cloning:

```bash
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-wp.xml
```

And type:

```text
...
<name>hologram-wp</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-wp (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.XXX)</title>
...
<source file='/var/lib/libvirt/images/hologram-wp.qcow2'/>
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
<host mac='XX:XX:XX:XX:XX:XX' name='hologram-wp' ip='192.168.1.XXX'/>
```

From bash shell:

```bash
virsh define hologram-wp.xml
```

Now from virsh cli:

```shell
net-start default
list --all --title
start hologram-wp
dominfo hologram-wp
domifaddr hologram-wp
```

### open `Virtual Machine Manager` GUI

#### into hologram-wp edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-wp
sudo nano /etc/hosts
sudo reboot
```

#### regenerate OpenSSH Host Keys

```bash
sudo grep -ir "hologram-php831" /etc
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
suspend hologram-wp
resume hologram-wp
save hologram-wp hologram-wp_dump
restore hologram-wp_dump
shutdown hologram-wp
reboot hologram-wp
```

Of course, you will need to replace the `X` with the appropriate values.
