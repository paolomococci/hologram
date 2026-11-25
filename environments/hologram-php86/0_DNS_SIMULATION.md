# notes

To improve the test environment, it is advisable to simulate the DNS using the `/etc/hosts` file present in the system hosting the virtual environment:

```conf
# Virtual Hosting on hologram-php86.local
192.168.1.86  hologram-php86.local          www.hologram-php86.local
192.168.1.86  opificium.local               www.opificium.local
192.168.1.86  knowledge.local               www.knowledge.local
192.168.1.86  normalize.local               www.normalize.local
```
