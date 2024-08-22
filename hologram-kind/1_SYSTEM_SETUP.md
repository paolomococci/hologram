# hologram-kind

Procedure for obtaining a basic system.

## useful commands

Once the installation is complete, you can use the following commands to become familiar with the system.
With root credentials:

```bash
su -
nmap -sn 192.168.1.0/24
nmap -sP 192.168.1.0/24
nmap -sV -O -v 192.168.1.XXX
exit
ssh developer_username@192.168.1.XXX
ls -al
uptime
uname --all
lscpu
lspci
lsblk
free -h
df -h
hostname -I
ip a
ip n
ip r
ss -tuna
su -
apt update
apt list --upgradable
apt upgrade
apt install curl unzip btop plocate net-tools ufw git libltdl7 pigz pwgen
apt autoclean
apt autopurge
```

A short command line to see, for example, the license of package `btop`:

```bash
awk '/^License:/ { print $1 $2 }' /usr/share/doc/btop/copyright
```

## firewall setup

```bash
ufw status
ufw enable
ufw allow from 192.168.1.0/24 proto tcp to any port 22
ufw allow from 192.168.1.0/24 proto tcp to any port 80
ufw allow from 192.168.1.0/24 proto tcp to any port 8080
ufw reload
ufw status numbered
ss -tuna | grep 22
ss -tuna | grep 80
ss -tuna | grep 8080
```

and, if I want to close a previously opened port, I have to issue the following commands:

```bash
ufw status numbered
ufw delete 2
ufw reload
```

## backup VM

On hologram-kind VM, with root credentials:

```bash
poweroff
```

And now, on host system, always with root credentials:

```bash
mkdir hologram-mini_backup && cd hologram-mini_backup
virsh dumpxml hologram-kind > ./hologram-kind.xml
virsh domblklist hologram-kind
cp /var/lib/libvirt/images/hologram-kind.qcow2 .
ls -al
```

So, if in the future something were to go irreparably wrong I can execute the following commands:

```bash
virsh list --all
virsh undefine --domain hologram-kind --remove-all-storage
cd vm_backup
ls -al
cp hologram-kind.qcow2  /var/lib/libvirt/images/
virsh define hologram-kind.xml
```

## network tools setup

It would be helpful to install some network tools:

```bash
apt install nmap ncat
```

## development tools and libraries

I will need the following packages:

* build-essential
* python3
* python3-pip

With the following command I can check if the package is already installed:

```bash
dpkg -l build-essential
```

To then proceed with installing the packages that are not yet present on the system.

As follows, for example only:

```bash
apt update  
apt install build-essential python3-pip
```
