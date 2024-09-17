# Network File System setup

## clients setup

The settings required on clients to use the service are as follows:

```bash
sudo -s
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
nano /etc/fstab
```

I adding a line similar to the following:

```text
192.168.1.XXX:/var/nfs  /mnt/shared nfs default 0 0
```
