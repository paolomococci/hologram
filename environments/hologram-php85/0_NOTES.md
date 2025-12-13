# notes

To improve the test environment, it is advisable to simulate the DNS using the `/etc/hosts` file present in the system hosting the virtual environment:

```conf
# Virtual Hosting on hologram-php85.local
192.168.1.85  hologram-php85.local          www.hologram-php85.local
192.168.1.85  opificium.local               www.opificium.local
```
