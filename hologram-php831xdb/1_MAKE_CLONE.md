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

Carry out the actual cloning:

```bash
cp hologram-php831.xml hologram-php831xdb.xml
cp hologram-php831.qcow2 hologram-php831xdb.qcow2
uuidgen
~/tools/latest_three_mac_gen.py
nano hologram-php831xdb.xml
```

And type:

```xml
...
<name>hologram-php831xdb</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>hologram-php831xdb (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.122.138)</title>
...
<source file='/var/lib/libvirt/images/hologram-php831xdb.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

### import hologram-php831

```bash
mv hologram-php831xdb.qcow2 /var/lib/libvirt/images/hologram-php831xdb.qcow2
```

Open a shell for the virsh cli:

```shell
net-edit default
```

Edit:

```xml
<host mac='XX:XX:XX:XX:XX:XX' name='hologram-php831xdb' ip='192.168.122.138'/>
```

From bash shell:

```bash
virsh define hologram-php831xdb.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start hologram-php831xdb
list --all --title
dominfo hologram-php831xdb
domifaddr hologram-php831xdb
```
