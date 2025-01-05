# PHP setup

## first I update the system

```bash
sudo apt update
```

And, if there are updates:

```bash
apt list --upgradable
sudo apt upgrade
```

## then I proceed to make a backup copy of the entire virtual system

Having acquired the `root` credentials on host system, I proceed with the backup:

```bash
mkdir --parents ~/vmdumps/backup/hologram-php56/ && cd ~/vmdumps/backup/hologram-php56/
virsh dumpxml hologram-php56 > ./hologram-php56.xml
virsh domblklist hologram-php56
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php56.qcow2 ./hologram-php56.qcow2
```

---

## how to add ppa following the documentation found online

Here's how to proceed for installing specific versions of PHP as defined by the documentation found online.
From here on I will list the steps that seem to be necessary, limiting myself only to listing them:

```bash
apt search software-properties-common
dpkg -l software-properties-common
```

If `software-properties-common` is not installed:

```bash
sudo apt install software-properties-common
```

Again, from here on out it's just a list of operations that I haven't tested:

```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt update
apt list --upgradable
sudo apt upgrade
```

## list of instructions for installing other packages

```bash
sudo apt install libapache2-mod-fcgid
```

## PHP 5.6

```bash
apt search php5.6
```

### basic installation

```bash
sudo apt install php5.6 php5.6-fpm php5.6-mysql libapache2-mod-php5.6
```

or, for greater completeness:

```bash
sudo apt install php5.6 php5.6-fpm libapache2-mod-php5.6 php5.6-common php5.6-xml php5.6-xmlrpc php5.6-curl php5.6-gd php5.6-imagick php5.6-cli php5.6-raphf php5.6-dev php5.6-imap php5.6-mbstring php5.6-opcache php5.6-soap php5.6-zip php5.6-bz2 php5.6-intl php5.6-mysql php5.6-pgsql php5.6-sqlite3 php5.6-redis php5.6-json php5.6-bcmath php5.6-bz2 php5.6-gnupg php5.6-grpc php5.6-http php5.6-imap php5.6-mailparse php5.6-pspell php5.6-readline php5.6-ssh2 php5.6-tidy php5.6-xml php5.6-xsl php5.6-yaml php5.6-ps php5.6-uploadprogress php5.6-mcrypt php5.6-gmp php5.6-xcache php5.6-xhprof php5.6-phpdbg php5.6-xdebug
```

Finally it is necessary to select the PHP version to use:

```bash
sudo update-alternatives --config php
```

According to the information gathered, a collision between different versions could persist at this point. In this case, perhaps, it will be necessary to remove the versions that are not of interest using `aptitude`.
