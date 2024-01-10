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
apt-cache search software-properties-common
dpkg -l software-properties-common
```

If `software-properties-common` is not installed:

```bash
sudo apt install software-properties-common
```
