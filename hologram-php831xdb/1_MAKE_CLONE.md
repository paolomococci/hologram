# make clone

## backup of originally virtual machine with root credentials

```bash
ls -al ~/vmdumps/backup/
mkdir ~/vmdumps/backup/hologram-php831/ && cd ~/vmdumps/backup/hologram-php831/
virsh dumpxml hologram-php831 > ./hologram-php831.xml
virsh domblklist hologram-php831
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php831.qcow2 ./hologram-php831.qcow2
```
