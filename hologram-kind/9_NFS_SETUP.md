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

So I only enable NFS version 4 or higher, by editing the `/etc/default/nfs-common` file.
I setting the following two variables with the specified values:

```conf
NEED_STATD="no"
NEED_IDMAPD="yes"
```

To do this I use the `perl` interpreter:

```bash
ls -l /etc/default/nfs-common
cat /etc/default/nfs-common
perl -pi -e 's/^NEED_STATD=/NEED_STATD="no"/' /etc/default/nfs-common
perl -pi -e 's/^NEED_IDMAPD=/NEED_IDMAPD="yes"/' /etc/default/nfs-common
rnano /etc/default/nfs-common
```

To complete the operation I also edited the file `/etc/default/nfs-kernel-server`.
By setting the following two variables:

```conf
RPCNFSDOPTS="-N 2 -N 3"
RPCMOUNTDOPTS="--manage-gids -N 2 -N 3"
```

To do this I use the `perl` interpreter and `echo` shell command:

```bash
ls -l /etc/default/nfs-kernel-server
cat /etc/default/nfs-kernel-server
perl -pi -e 's/^RPCMOUNTDOPTS="--manage-gids"/RPCMOUNTDOPTS="--manage-gids -N 2 -N 3"/' /etc/default/nfs-kernel-server
echo 'RPCNFSDOPTS="-N 2 -N 3"' >> /etc/default/nfs-kernel-server
cat /etc/default/nfs-kernel-server
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

To simplify things, just for example, I could allow full access to all users of the system:

```bash
chmod 777 /mnt/shared
exit
```

To then write a file to the shared directory as a user with normal privileges:

```bash
echo "Example of writing simple text to a file hosted in a shared directory using NFS." > /mnt/shared/example.txt
cat /mnt/shared/example.txt
```

Or, I could restrict these privileges to a specific group of system users.

### umount the shared directory

Finally, to `umount` the shared directory I will have to issue the following command:

```bash
umount -l /mnt/shared
```

But, to set the mount at client systems boot, I will need to edit the `/etc/fstab` file: 

```bash
ls -l /etc/fstab
```

I adding a line similar to the following:

```text
192.168.1.XXX:/var/nfs  /mnt/shared nfs default 0 0
```

With the following command:

```bash
echo "192.168.1.XXX:/var/nfs	/mnt/shared	nfs	defaults	0	0" >> /etc/fstab
```

I create the file `/etc/network/if-up.d/fstab`:


```bash
nano /etc/network/if-up.d/fstab
```

And I edit it as follows:

```bash
#!/bin/bash
mount --all
```

I do a check, make it executable and finally reboot the system:

```bash
cat /etc/network/if-up.d/fstab
chmod 755 /etc/network/if-up.d/fstab
reboot
```

*It goes without saying that the correct IP address must be entered.*
