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
