# notes

To improve the test environment, it is advisable to simulate the DNS using the `/etc/hosts` file present in the system hosting the virtual environment:

```conf
# Virtual Hosting on hologram-php84.local
192.168.1.84  hologram-php84.local          www.hologram-php84.local
192.168.1.84  sample-php84.local            www.sample-php84.local
192.168.1.84  playground-php84.local        www.playground-php84.local
192.168.1.84  landing-php84.local           www.landing-php84.local
192.168.1.84  remark-php84.local            www.remark-php84.local
192.168.1.84  recode-php84.local            www.recode-php84.local
192.168.1.84  thesis-php84.local            www.thesis-php84.local
192.168.1.84  posts-php84.local             www.posts-php84.local
192.168.1.84  catenaria-php84.local         www.catenaria-php84.local
```
