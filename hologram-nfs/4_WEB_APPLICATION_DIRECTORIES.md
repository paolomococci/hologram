# application directories

Directories that will be used by the web application MIS, (Management Information System).
Directories reflect the tiers that make up the application:
- frontend;
- backend;
- datastore.

## directories export

I create three new directories in `/var/` and expose them on the local network:

```bash
ls -l /var/
mkdir -p /var/frontend
mkdir -p /var/backend
mkdir -p /var/datastore
chown nobody:nogroup /var/frontend
chown nobody:nogroup /var/backend
chown nobody:nogroup /var/datastore
ls /etc/exports
echo "/var/frontend 192.168.1.0/24(rw,sync,no_subtree_check)" >> /etc/exports
echo "/var/backend 192.168.1.0/24(rw,sync,no_subtree_check)" >> /etc/exports
echo "/var/datastore 192.168.1.0/24(rw,sync,no_subtree_check)" >> /etc/exports
cat /etc/exports
exportfs -a
exportfs -s
```

*I will use the `/mnt/shared` directory, created initially, for application development.*
