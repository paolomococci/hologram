# install and setup Docker Engine

Install from `apt` repository:

```bash
ssh developer_username@192.168.1.XXX
su -
apt update
apt list --upgradable
apt upgrade
dpkg -l ca-certificates
```

and, if the aforementioned package is not installed, proceed with the following command:

```bash
apt install ca-certificates
```

Now let's get to the heart of the installation:

```bash
ls -al /etc/apt/keyrings
```

and if the folder does not exist or does not have the right permissions:

```bash
install -m 0755 -d /etc/apt/keyrings
```

Then continue with the following commands:

```bash
curl -fsSL https://download.docker.com/linux/debian/gpg -o /etc/apt/keyrings/docker.asc
ls -al /etc/apt/keyrings/docker.asc
stat --format='%a -> %n' /etc/apt/keyrings/docker.asc
```

if the file `docker.asc` is not readable by everyone and writable only by root, it will be necessary to issue the following command:

```bash
chmod 644 /etc/apt/keyrings/docker.asc
```

Add the repository to `sources.list`:

```bash
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/debian $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null
```

The following commands are used to update the information of the available packages and to obtain more information on what you are about to install:

```bash
apt update
apt show docker-ce
apt show docker-ce-cli
apt show containerd.io
apt show docker-buildx-plugin
apt show docker-compose-plugin
```

Install Docker packages:

```bash
apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

A short command line to see the licenses of the newly installed `containerd.io` package:

```bash
awk '/^License:/ { print $1 $2 }' /usr/share/doc/containerd.io/copyright
```

for other packages it will be necessary to open the appropriate directories.

Now I can check the correct installation with `hello-world` image:

```bash
docker run hello-world
```

## post-installation setup for non-root users

```bash
exit
id -u
whoami
cat /etc/group
grep -i "developer_username" /etc/group
grep -i "docker" /etc/group
```

if this last group is not present, as root user, I will necessarily have to execute the following commands:

```bash
su -
groupadd docker
```

Otherwise, I can add the developer user to group `docker`:

```bash
su -
usermod -a -G docker developer_username
```

Now I can do a little check:

```bash
grep -i "docker" /etc/group
```

Try running the docker command issued by a non-root user with `hello-world` image:

```bash
exit
newgrp docker
docker run hello-world
```

## how to configure Docker to start on boot thanks systemd

First I will necessarily have to impersonate the root user again and verify that the services are not already enabled:

```bash
su -
systemctl status docker.service --no-pager --full
systemctl status containerd.service --no-pager --full
```

If the services are not enabled and active, I can proceed with the following commands:

```bash
systemctl enable docker.service
systemctl enable containerd.service
```

Subsequently, if I don't want `Docker` to start at system boot, I will have to issue the following commands:

```bash
systemctl disable docker.service
systemctl status docker.service --no-pager --full
systemctl disable containerd.service
systemctl status containerd.service --no-pager --full
```
