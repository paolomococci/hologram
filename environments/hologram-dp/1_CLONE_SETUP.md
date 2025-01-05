# I create a clone for a CMS installation example

## backup of originally virtual machine with root credentials

```bash
ls -al ~/vmdumps/
cd ~/vmdumps/
virsh dumpxml hologram-php831 > ./hologram-dp.xml
virsh domblklist hologram-php831
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php831.qcow2 /var/lib/libvirt/images/hologram-dp.qcow2
```

Carry out the actual cloning:

```bash
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-dp.xml
```

And type:

```text
...
<name>hologram-dp</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-dp (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.XXX)</title>
...
<source file='/var/lib/libvirt/images/hologram-dp.qcow2'/>
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
<host mac='XX:XX:XX:XX:XX:XX' name='hologram-dp' ip='192.168.1.XXX'/>
```

From bash shell:

```bash
virsh define hologram-dp.xml
```

Now from virsh cli:

```shell
net-start default
list --all --title
start hologram-dp
dominfo hologram-dp
domifaddr hologram-dp
```

### open `Virtual Machine Manager` GUI

#### into hologram-dp edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname hologram-dp
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
sudo du --human-readable --summarize /var/cache/apt/archives/
sudo apt-get autoclean
```

From the virsh cli I can, among other things:

```shell
suspend hologram-dp
resume hologram-dp
save hologram-dp hologram-dp_dump
restore hologram-dp_dump
shutdown hologram-dp
reboot hologram-dp
```

Of course, you will need to replace the `X` with the appropriate values.
