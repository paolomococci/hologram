# Network File System setup

## client setup

The settings required on clients to use the service are as follows:

```bash
su -
apt show nfs-common
dpkg -l nfs-common
apt install nfs-common
ls -l /mnt/
mkdir -p /mnt/shared
mkdir -p /mnt/frontend
mkdir -p /mnt/backend
mkdir -p /mnt/datastore
mount 192.168.1.XXX:/var/nfs /mnt/shared
mount 192.168.1.XXX:/var/frontend /mnt/frontend
mount 192.168.1.XXX:/var/backend /mnt/backend
mount 192.168.1.XXX:/var/datastore /mnt/datastore
```

To simplify things, just for example, I could allow full access to all users of the system:

```bash
chmod 777 /mnt/shared
chmod 777 /mnt/frontend
chmod 777 /mnt/backend
chmod 777 /mnt/datastore
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
echo "192.168.1.XXX:/var/frontend	/mnt/frontend	nfs	defaults	0	0" >> /etc/fstab
echo "192.168.1.XXX:/var/backend	/mnt/backend	nfs	defaults	0	0" >> /etc/fstab
echo "192.168.1.XXX:/var/datastore	/mnt/datastore	nfs	defaults	0	0" >> /etc/fstab
tail /etc/fstab
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
