# hologram-php  (ubuntu server 22.04 LTS)

Procedure for installing Linux servers to be used for the development and production of full-stack web applications.

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
sudo reboot
ssh developer_username@192.168.1.XXX
lsb_release -a
sudo apt update
apt list --upgradable
sudo apt upgrade
sudo apt-get autopurge
```

## set up timezone if necessary

```bash
sudo tzselect
```

## set up LAMP system

```bash
dpkg -l openssl
sudo apt install ufw apache2 mariadb-server curl unzip
sudo ufw enable
sudo ufw status
sudo ufw allow from 192.168.1.0/24 proto tcp to any port 22
sudo ufw allow from 192.168.1.0/24 proto tcp to any port 80
sudo ufw allow from 192.168.1.0/24 proto tcp to any port 3306
sudo ufw reload
sudo ufw status numbered
groups
sudo usermod -a -G www-data developer_username
sudo reboot
groups
cd /var/www/
sudo chown --recursive --verbose developer_username:www-data html
sudo systemctl status apache2 -l --no-pager
sudo systemctl list-units
```

## install and upgrade nodejs and npm

```bash
sudo apt install nodejs npm
sudo npm cache clean -f
sudo npm install -g n
sudo n stable
```

Additionally, it would be helpful to install some system tools:

```bash
sudo apt install plocate btop nmap ncat traceroute net-tools
```

And if you want to compile PHP from source, if not previously installed, you will need the following packages:

* build-essential
* autoconf
* libtool
* bison
* re2c
* pkg-config

With the following command you can check if the package is already installed:

```bash
dpkg -l build-essential
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
