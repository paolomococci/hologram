# virsh help

I will try to exemplify as much as possible the procedure for cloning a KVM based virtual machine.
The host system is GNU/Linux Debian 12.
I have previously prepared a virtual machine called hologram-php, a LAMP stack which only needs to define the PHP version.

## clone a virtual machine hologram-php

With root credentials:

```bash
mkdir ~/vmdumps/hologram-php/
cd ~/vmdumps/hologram-php/
virsh dumpxml hologram-php > ./hologram-php.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2 ./hologram-php.qcow2
```
