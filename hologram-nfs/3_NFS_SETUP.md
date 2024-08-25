# Network File System setup

## server setup

### kernel check

First I need to make sure I have NFS support in the kernel:

```bash
su -
ls -l /boot/config-`uname -r`
grep -i "nfsd" /boot/config-`uname -r`
```

### packages install

I install packages `nfs-kernel-server` and `rpcbind`:

```bash
apt update
apt install nfs-kernel-server rpcbind
```

### rpcbind setup

I setup `rpcbind` so that it accepts requests from all hosts on the local network.
To do this I now use the `perl` interpreter instead of the `sed` editor on file `/etc/default/rpcbind`:

```bash
perl --help
perl -pi -e 's/^OPTIONS/#OPTIONS/' /etc/default/rpcbind
```

I add a string indicating the local network to the `/etc/hosts.allow` file:

```bash
echo "rpcbind: 192.168.1." >> /etc/hosts.allow
```

and then I restart the service `rpcbind`:

```bash
systemctl status rpcbind
systemctl restart rpcbind
```

### directory export

I create the directory `/var/nfs/` and make it exposed on the local network:

```bash
ls -l /var/
mkdir -p /var/nfs
chown nobody:nogroup /var/nfs
ls /etc/exports
less /etc/exports
echo "/var/nfs 192.168.1.0/24(rw,sync,no_subtree_check)" >> /etc/exports
exportfs -a
```

and then I restart the service `nfs-kernel-server`:

```bash
systemctl status nfs-kernel-server
systemctl restart nfs-kernel-server
```

### firewall setup

I open the firewall to the NFS service:

```bash
ufw status numbered
ufw allow from 192.168.1.0/24 to any port nfs
ufw reload
ufw status numbered
```

### NFS version setup

Now I check which versions of NFS the server supports:

```bash
cat /proc/fs/nfsd/versions
```

So I only enable NFS version 4 or higher, by editing the `/etc/default/nfs-common` file:

```bash
ls -l /etc/default/nfs-common
nano /etc/default/nfs-common
```

I setting the following two variables with the specified values:

```conf
NEED_STATD="no"
NEED_IDMAPD="yes"
```

To complete the operation I also edited the file `/etc/default/nfs-kernel-server`:

```bash
ls -l /etc/default/nfs-kernel-server
nano /etc/default/nfs-kernel-server
```

By setting the following two variables:

```conf
RPCNFSDOPTS="-N 2 -N 3"
RPCMOUNTDOPTS="--manage-gids -N 2 -N 3"
```

## clients setup

The settings required on clients to use the service are as follows:

```bash
su -
apt show nfs-common
dpkg -l nfs-common
apt install nfs-common
ls -l /mnt/
mkdir -p /mnt/shared
mount 192.168.1.XXX:/var/nfs /mnt/shared
```

Finally, to `umount` the shared directory I will have to issue the following command:

```bash
umount -l /mnt/shared
```

But, to set the mount at client systems boot, I will need to edit the `/etc/fstab` file: 

```bash
ls -l /etc/fstab
nano /etc/fstab
```

I adding a line similar to the following:

```text
192.168.1.XXX:/var/nfs  /mnt/shared nfs default 0 0
```
