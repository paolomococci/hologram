# hologram-kind

Procedure to get a system to customize later.

## useful commands

Once the installation is complete, with root credentials, I can use the following commands to become familiar with the system:

```bash
hostname -I
ls -al
uptime
uname --all
lscpu
lspci
lsblk
free -h
df -h
su -
apt update
apt list --upgradable
apt upgrade
apt install curl unzip btop plocate net-tools ufw git libltdl7 pigz nmap ncat
apt autoclean
apt autopurge
nmap -sn 192.168.1.0/24
nmap -sP 192.168.1.0/24
nmap -sV -O -v 192.168.1.XXX
ip a
ip n
ip r
ss -tuna
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
ufw allow from 192.168.1.0/24 proto tcp to any port 3306
ufw allow from 192.168.1.0/24 proto tcp to any port 8080
ufw allow from 192.168.1.0/24 proto tcp to any port 8443
ufw allow from 192.168.1.0/24 proto tcp to any port 9003
ufw reload
ufw status numbered
ss -tuna | grep 22
ss -tuna | grep 80
ss -tuna | grep 3306
ss -tuna | grep 8080
ss -tuna | grep 8443
ss -tuna | grep 9003
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
