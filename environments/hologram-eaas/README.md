# hologram-eaas (Environment as a Service)

Looking ahead, I am preparing a set of procedures to build the backbone of a local multi-node Eaas, (Environment as a Service), example.
A type of Eaas in `on premise` configuration thanks to a virtual server with GNU/Linux AlmaLinux 9.4 installed.
A great alternative is also Rocky Linux.

## adapt to SELinux

When using this distribution you need to consider the `SELinux` system.
For example, directories used by containers must have a property set correctly:

```bash
ls -lZ
chcon --recursive --type=container_file_t html
```

## further useful notes

### extend the capacity of the `home` partition

If I needed to extend the capacity of the home partition, starting with adding a new storage device.
And then I ran the following commands:

```bash
df -Th
lsblk -f
pvcreate /dev/vdb
vgextend volume_group_name /dev/vdb
vgs
vgdisplay
lvs
lvextend --extents +100%FREE /dev/volume_group_name/home
df -Th
lsblk -f
```

### remove old system from the keychain:

```bash
ssh-keygen -f '/home/developer_username/.ssh/known_hosts' -R '[192.168.1.XXX]:8022'
ssh root@192.168.1.XXX -p 8022
```

## it is good to remember

It's good to remember that the link addresses mentioned in the procedures may change.
The procedures themselves may change or there may be more convenient ones.
Therefore, it is always necessary to refer to the official documentation hosted on the sites of the programming languages, servers and tools mentioned from time to time.
Thank you.
