# hologram-root

Procedure for obtaining a basic system.

## install

Attention, deselect LVM.
Otherwise, an intervention will be necessary later to increase the disk space.

## remove the predisposition to cloud

```bash
ssh developer_username@192.168.1.XXX
sudo touch /etc/cloud/cloud-init.disabled
sudo dpkg-reconfigure cloud-init
```

Deselect all entries except `None`.

```bash
sudo reboot
ssh developer_username@192.168.1.XXX
sudo apt-get purge cloud-init
sudo rm -rf /etc/cloud/
sudo rm -rf /var/lib/cloud/
sudo apt-get autopurge
sudo reboot
ssh developer_username@192.168.1.XXX
lsb_release -a
sudo apt update
apt list --upgradable
sudo apt upgrade
sudo apt install curl unzip btop plocate net-tools
sudo apt-get autopurge
sudo du --human-readable --summarize /var/cache/apt/archives/
```

## set up timezone if necessary

```bash
sudo tzselect
```

## firewall setup

```bash
sudo ufw enable
sudo ufw allow from 192.168.1.0/24 proto tcp to any port 22
sudo ufw reload
sudo ufw status numbered
```
