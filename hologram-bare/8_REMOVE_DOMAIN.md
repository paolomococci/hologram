# how to remove the no longer needed domain

Once the migration to a more recent version of PHP has been completed and everything has been transferred to the production server, the resource no longer needed can be removed.

```shell
virsh undefine hologram-bare --storage /var/lib/libvirt/images/hologram-bare.qcow2
```
