# how to remove the no longer needed domain

Once development is complete and everything has been pushed to the production server, the resource no longer needed can be removed.

```shell
virsh undefine landing --storage /var/lib/libvirt/images/landing.qcow2
```

If, however, you want to keep a test and development version of the web application on this virtual machine, it is better to skip this last step.
