# hologram-caas

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
cat /etc/debian_version
apt update
apt list --upgradable
apt upgrade
apt install curl unzip btop plocate net-tools ufw git libltdl7 pigz nmap ncat
apt autoclean
apt autopurge
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

## some tests run by another host on the network

```bash
nmap -sn 192.168.1.0/24
nmap -sP 192.168.1.0/24
nmap -sV -O -v 192.168.1.XXX
nmap 192.168.1.XXX -Pn -p 22
nmap 192.168.1.XXX -Pn -p 80
nmap 192.168.1.XXX -Pn -p 8080
```

## backup VM

On hologram-caas VM, with root credentials:

```bash
poweroff
```

And now, on host system, always with root credentials:

```bash
mkdir vm_backup && cd vm_backup
virsh dumpxml hologram-caas > ./hologram-caas.xml
ls -al
virsh domblklist hologram-caas
cp /var/lib/libvirt/images/hologram-caas.qcow2 .
ls -al
```

So, if in the future something were to go irreparably wrong I can execute the following commands:

```bash
virsh list --all
virsh undefine --domain hologram-caas --remove-all-storage
cd vm_backup
ls -al
cp hologram-caas.qcow2  /var/lib/libvirt/images/
virsh define hologram-caas.xml
```
