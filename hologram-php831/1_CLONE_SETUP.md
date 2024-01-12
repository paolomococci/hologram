# hologram-php831 clone

## clone a virtual machine hologram-php

with root credentials:

```bash
ls -al ~/vmdumps/backup/
mkdir ~/vmdumps/backup/hologram-php/ && cd ~/vmdumps/backup/hologram-php/
virsh dumpxml hologram-php > ./hologram-php831.xml
virsh domblklist hologram-php
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php.qcow2  /var/lib/libvirt/images/hologram-php831.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-php831.xml
```

edit hologram-php.xml

```text
...
<name>hologram-php831</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php831 (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.12.)</title>
...
<source file='/var/lib/libvirt/images/hologram-php831.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

From virsh cli:

```shell
net-edit default
```

edit:

```text
...
<dhcp>
    <range start='192.168.1.2' end='192.168.1.254'/>
    <host mac='XX:XX:XX:XX:XX:XX' name='hologram-php831' ip='192.168.1.12'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define hologram-php831.xml
```

and from virsh cli:

```shell
list --all --title
net-start default
start hologram-php831
dominfo hologram-php831
domifaddr hologram-php831
```
