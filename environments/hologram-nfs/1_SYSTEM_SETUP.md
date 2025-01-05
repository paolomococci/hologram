# hologram-nfs

Procedure to get a system to customize later.

## useful commands

Once the installation is complete, with root credentials, I can use the following commands to become familiar with the system:

```bash
ls -al
hostname -I
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
apt install curl unzip btop plocate net-tools ufw git pigz nmap ncat
apt autoclean
apt autopurge
uptime
ip a
ip n
ip r
ss -tuna
nmap -sn 192.168.1.0/24
nmap -sP 192.168.1.0/24
nmap -sV -O -v 192.168.1.XXX
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
ufw reload
ufw status numbered
ss -tuna | grep 22
```
