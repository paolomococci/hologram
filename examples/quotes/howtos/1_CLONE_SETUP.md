# clone setup

## clone a virtual machine landing

With root credentials, if directory `domains` does not exist:

```bash
mkdir domains
```

otherwise we proceed with cloning the virtual machine:

```bash
cd domains/
virsh dumpxml landing > ./quotes.xml
virsh domblklist landing
ls -al /var/lib/libvirt/images/
cp /var/lib/libvirt/images/landing.qcow2 /var/lib/libvirt/images/quotes.qcow2
```

Make the appropriate changes:

```bash
uuidgen
~/tools/latest_three_mac_gen.py
nano quotes.xml
```

And type:

```xml
...
<name>quotes</name>
  <uuid>XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</uuid>
  <title>quotes (Ubuntu server 22.04.3 LTS JAMMY JELLYFISH - 192.168.1.XXX)</title>
...
<source file='/var/lib/libvirt/images/quotes.qcow2'/>
...
<mac address='XX:XX:XX:XX:XX:XX'/>
...
```

### import landing

Open a shell for the virsh cli:

```shell
net-list
net-info default
net-destroy default
net-edit default
net-start default
```

edit

```xml
<host mac='XX:XX:XX:XX:XX:XX' name='quotes' ip='192.168.1.XXX'/>
```

From bash shell:

```bash
virsh define quotes.xml
```

Now from virsh cli:

```shell
list --all --title
start quotes
list --all --title
dominfo quotes
domifaddr quotes
```

### open GUI

#### into quotes edit setting files linked to the hostname

```bash
sudo nano /etc/hostname
sudo nano /etc/hosts
sudo reboot
```

or:

```bash
sudo hostnamectl set-hostname quotes
sudo nano /etc/hosts
sudo reboot
```

#### regenerate OpenSSH Host Keys

```bash
sudo grep -ir "landing" /etc
sudo rm /etc/ssh/ssh_host_*
sudo dpkg-reconfigure openssh-server
sudo reboot
```

From the virsh cli I can, among other things:

```shell
suspend quotes
resume quotes
save quotes landing_dump
restore landing_dump
shutdown quotes
reboot quotes
```
