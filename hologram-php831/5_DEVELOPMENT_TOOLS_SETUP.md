# development tools and libraries

## installing some development tools that I think are almost indispensable

Therefore, if you had not previously done so, proceed with the installation and update as follows:

```bash
sudo apt install libapache2-mod-fcgid plocate btop nodejs npm
sudo npm cache clean -f
sudo npm install -g n
sudo n stable
```

`libapache2-mod-fcgid` it is necessary to use PHP-FPM.

Additionally, it would be helpful to install some system tools:

```bash
sudo apt install plocate btop nmap ncat traceroute net-tools
```
