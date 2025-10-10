# containerization of PHP development environment

A procedure for creating a highly customized Docker image, solely for educational or development purposes.

**Be careful, this procedure can be extremely computationally resource-intensive and time-consuming, and something can always go wrong, forcing anyone who has consciously chosen to follow it to repeatedly start over!**

## `lamp-landing-cntr-1-0` is an example of use in development sessions

In this example I try to customize an image named `lamp-landing-img:1.0`

*This demo provides all the tools to develop an application from within, but does not use an external database. It simply stores the data in a SQLite file.*

## create an example of container

```shell
ls ~/templates/Landing/landingLAMP/
cd ~/templates/Landing/landingLAMP/
```

First I will need to create the settings files and web content in their respective directories.
The same files and directories that will be used in the `COPY` commands expressed in `Dockerfile`.
Including self-signed certificates, generated, for example, as follows:

```bash
ls -l conf/self-signed-certificates
openssl req -new -x509 -days 365 -out conf/self-signed-certificates/landing.pem -keyout conf/self-signed-certificates/landing.key
```

Here is just an example of the parameters to keep on hand:

```text
[secure_passphrase]
[national_acronym]
[state]
[city]
landing.local
landing.local
landing.local
[webmaster@localhost]
```

Long passphrase generated with:

```bash
pwgen -s 48 1
```

or with:

```bash
date +%s | sha512sum | base64 | head -c 48 ; echo
```

It is obvious that the first four parameters must be appropriately valued.

A short script `echo_passphrase.sh` similar to the following must be written in directory `self-signed-certificates`:

```text
#!/bin/sh
echo "secure_passphrase"
```

### Adapt the directory `html` for use with containers:

```shell
ls -ldZ ./html/
chcon --recursive --type=container_file_t ./html/
ls -ldZ ./html/
```

**Be careful, if you don't adapt the X directory for use with containers the site will not work.**

## image build

Once the example web application is built I can issue the following command:

```shell
podman image ls | grep "lamp-landing-img"
cat Dockerfile
# Remember to replace the placeholder with your current IP address.
podman build --build-arg XDEBUG_CLIENT_HOST=192.168.XXX.XXX --build-arg ROOT_PASSWORD=$(<./setup.txt) --tag lamp-landing-img:1.0 .
```

The output of this command should also contain the digest of the newly created local image.

Remember that, if you prefer, you can have the root password automatically generated when creating the container with the following command:

```shell
# Remember to replace the placeholder with your current IP address.
podman build --build-arg XDEBUG_CLIENT_HOST=192.168.XXX.XXX --tag lamp-landing-img:1.0 .
```

omitting the file containing the chosen password.
However, it should be noted that the generated password will be visible in the logs.

Now I continue with the verification of some details:

```shell
podman image ls | grep "lamp-landing-img"
podman images --no-trunc --quiet lamp-landing-img:1.0
podman image inspect lamp-landing-img:1.0
```

### create the container

The `html` directory contains a simple technical PHP info page, a placeholder. But this time the container has all the tools to develop an application from within and the above mentioned directory serves to make this operation permanent, even after the container is stopped.

Here are all the instructions you need to customize an image and get the container working:

```shell
podman container ls --all
podman run --volume $(pwd)/html:/var/www/html --detach --name lamp-landing-cntr-1-0 --publish 8022:22 --publish 8080:80 --publish 8443:443 --publish 9003:9003 --pull=never lamp-landing-img:1.0
podman container ls --all --size
podman exec --interactive --tty --privileged lamp-landing-cntr-1-0 shell
```

### open a shell shell in the container

Examples of commands typed into container shell:

```shell
ip help
ip link
ip address
ip route
ip neigh
apache2ctl configtest
# The following series of commands is used to ensure, among other things, that files 000-default.conf and default-ssl.conf have been set up correctly.
apache2ctl -M | grep -i ssl && apache2ctl -t -D DUMP_VHOSTS && ss -tunlp | grep ':443'
ls -l /var/log/apache2/access.log
cat /var/log/apache2/access.log
tail --follow --lines=20 /var/log/apache2/access.log
ls -l /var/log/apache2/error.log
cat /var/log/apache2/error.log
tail --follow --lines=20 /var/log/apache2/error.log
exit
```

### login via OpenSSH from another host

I log in from the system that hosts the containers:

```shell
# Remember to replace the placeholder with your current IP address.
nmap -Pn 192.168.XXX.XXX
ssh -p 8022 root@192.168.XXX.XXX
```

Note, after repeated testing, you may need to use the following command:

```shell
ssh-keygen -f "/home/developer_name/.ssh/known_hosts" -R "[192.168.XXX.XXX]:8022"
```

so as to avoid the following warning: "REMOTE HOST IDENTIFICATION HAS CHANGED!".

Now I try the following command to see if all the expected processes are running:

```shell
ps -eo 'tty,pid,comm' | grep ^?
```

and I can check the use of some tools:

```shell
composer --version
npm -v
node -v
```

### example of sftp.json for `vscode`

**Remember to replace the placeholder with your current IP address.**

```json
{
    "$schema": "http://json-schema.org/draft-07/schema",
    "name": "lamp-landing-cntr-1-0",
    "username": "root",
    "password": "some_password",
    "host": "192.168.XXX.XXX",
    "port": 8022,
    "remotePath": "/var/www/html",
    "connectTimeout": 20000,
    "uploadOnSave": true,
    "watcher": {
        "files": "dist/*.{js,css}",
        "autoUpload": false,
        "autoDelete": false
    },
    "syncOption": {
        "delete": true,
        "update": false
    },
    "ignore": [
        ".vscode",
        ".howto",
        ".docs",
        ".git",
        ".DS_Store",
        "TEMP",
        "nbproject",
        "probe.http"
    ]
}
```

So I have a complete debugging-enabled development environment for which I can arbitrarily choose versions of language PHP, the dependency manager Composer and frameworks Laravel and Node.js.

### stop the container

I can use the container name like this:

```shell
podman stop lamp-landing-cntr-1-0
```

### restart the container

I can proceed to restarting `lamp-landing-cntr-1-0` in privileged mode:

```shell
podman container ls --all
podman start lamp-landing-cntr-1-0
podman exec --interactive --tty --privileged lamp-landing-cntr-1-0 shell
```

### from another host on the network you can check connectivity with the following commands

```shell
# Remember to replace the placeholder with your current IP address.
nc -vz -w 3 192.168.XXX.XXX 8022
nc -vz -w 3 192.168.XXX.XXX 8080
nc -vz -w 3 192.168.XXX.XXX 8443
nc -vz -w 3 192.168.XXX.XXX 9003
```

Getting something like this respectively:

```txt
Connection to 192.168.XXX.XXX 8022 port [tcp/*] succeeded!
Connection to 192.168.XXX.XXX 8080 port [tcp/http-alt] succeeded!
Connection to 192.168.XXX.XXX 8443 port [tcp/*] succeeded!
Connection to 192.168.XXX.XXX 9003 port [tcp/*] succeeded!
```

Sorry, but I have to repeat it, taking care to replace the above placeholders, (192.168.XXX.XXX), with the correct IP addresses.

## to clean up

### remove container

```shell
podman stop lamp-landing-cntr-1-0 && podman rm lamp-landing-cntr-1-0
podman container ls --all
```

### remove image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```shell
podman image rm lamp-landing-img:1.0
podman images --all
```

---

## possible scaffolding of a Laravel application

Then I create the directory that will be used to consolidate the volume that will host the container web content and make the source code in it persistent:

```shell
cd /var/www/html/
composer --version
composer create-project laravel/laravel landing
```

Please note that the following are key steps for the correct functioning of the web application:

```shell
sudo -s
chown --recursive --verbose 1000:33 landing
cd landing
chmod --recursive 775 bootstrap/cache
chmod --recursive 775 storage
chmod --recursive 775 database
php artisan cache:clear
exit
```
