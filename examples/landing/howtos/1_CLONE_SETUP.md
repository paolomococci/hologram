# landing clone

## clone a virtual machine hologram-php83

With root credentials, if directory `domains` does not exist:

```bash
mkdir domains
```

otherwise we proceed with cloning the virtual machine:

```bash
cd domains/
virsh dumpxml hologram-php83 > ./landing.xml
virsh domblklist hologram-php83
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/hologram-php83.qcow2 /var/lib/libvirt/images/landing.qcow2
```

Make the appropriate changes:

```bash
uuidgen
~/tools/latest_three_mac_gen.py
nano landing.xml
```

Edit `landing.xml`:

```xml
...
<name>landing</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>landing (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.105)</title>
...
<source file='/var/lib/libvirt/images/landing.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

If you prefer, `sed` can be used, for example:

```bash
sed -i 's/hologram-php83/landing/g' landing.xml
sed -i 's/192.168.1.83/192.168.1.105/g' landing.xml
```

and so on, also for the other values to be modified.

From virsh cli:

```shell
net-list
net-info default
net-destroy default
net-edit default
net-start default
```

Edit:

```xml
...
<dhcp>
    <range start='192.168.1.2' end='192.168.1.254'/>
    <host mac='XX:XX:XX:XX:XX:XX' name='landing' ip='192.168.1.105'/>
</dhcp>
...
```

From bash shell type:

```bash
virsh define landing.xml
```

Now from virsh cli:

```shell
list --all --title
net-start default
start landing
dominfo landing
domifaddr landing
```

### open GUI

#### into landing edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname landing
sudo nano /etc/hosts
sudo reboot
```

#### regenerate OpenSSH Host Keys

```bash
sudo grep -ir "hologram-php83" /etc
sudo rm /etc/ssh/ssh_host_*
sudo dpkg-reconfigure openssh-server
sudo reboot
```

From the virsh cli I can, among other things:

```shell
suspend landing
resume landing
save landing landing_dump
restore landing_dump
shutdown landing
reboot landing
```
