# `laravel-landing-1.2` how to customize an image named `laravel-landing-img:1.2`

*This demo provides all the tools to develop an application from within, but does not use an external database. It simply stores the data in a SQLite file.*

## create an example of container

```bash
ls ~/project/templates/frontend/laravel-landing-1.2
cd ~/project/templates/frontend/laravel-landing-1.2
```

First I will need to create the settings files and web content in their respective directories.
The same files and directories that will be used in the `COPY` commands expressed in `Dockerfile`.
Including self-signed certificates, generated, for example, as follows:

```bash
ls -l conf/self-signed-certificates
openssl req -new -x509 -days 365 -out conf/self-signed-certificates/hologram.pem -keyout conf/self-signed-certificates/hologram.key
```

Here is just an example of the parameters to keep on hand:

```text
[long_passphrase]
[national_acronym]
[state]
[city]
hologram.local
hologram.local
hologram.local
[webmaster@localhost]
```

Long_passphrase generated with:

```bash
pwgen -s 48 1
```

It is obvious that the first four parameters must be appropriately valued.

A short script `echo_passphrase.sh` similar to the following must be written in directory `self-signed-certificates`:

```text
#!/bin/sh
echo "long_passphrase"
```

A directory must be created `mods-available` with a file inside named `dir.conf` containing text similar to the following:

```xml
<IfModule mod_dir.c>
        DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```

A directory must be created `sites-available` with a file inside named `default-ssl.conf` containing the text:

```xml
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName hologram.local
                ServerAlias www.hologram.local
                DocumentRoot /var/www/html/landing/public

                <Directory /var/www/html/landing/public>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                </Directory>

                LogLevel warn

                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/hologram.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/hologram.key

                <FilesMatch "\.(cgi|shtml|phtml|php)$">
                    SSLOptions +StdEnvVars
                </FilesMatch>

                <Directory /usr/lib/cgi-bin>
                    SSLOptions +StdEnvVars
                </Directory>
        </VirtualHost>
</IfModule>
```

and a file named `default-ssl.conf` with the following text:

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName hologram.local
        ServerAlias www.hologram.local
        DocumentRoot /var/www/html/landing/public

        <Directory /var/www/html/landing/public>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

## scaffolding the application

Then I create the directory that will be used to consolidate the volume that will host the container web content and make the source code in it persistent:

```bash
mkdir html
composer --version
composer create-project laravel/laravel landing
```

Please note that the following are key steps for the correct functioning of the web application:

```bash
sudo -s
chown --recursive --verbose 1000:33 landing
cd landing
chmod --recursive 775 bootstrap/cache
chmod --recursive 775 storage
chmod --recursive 775 database
php artisan cache:clear
exit
```

In defining the owner and group of the directory `landing` I used the numeric identifiers obtained from the following command:

```bash
cat /etc/passwd
```

### image build

Once the example web application is built I can issue the following command:

```bash
docker image ls | grep "laravel-landing-img"
cat Dockerfile
docker build --tag laravel-landing-img:1.2 .
```

The output of this command should also contain the digest of the newly created local image.

I continue with the verification of some details:

```bash
docker images --all
docker images --no-trunc --quiet laravel-landing-img:1.2
docker image inspect laravel-landing-img:1.2
```

### create the container

The `html` directory contains a simple technical PHP info page, a placeholder. But this time the container has all the tools to develop an application from within and the above mentioned directory serves to make this operation permanent, even after the container is stopped.

Here are all the instructions you need to customize an image and get the container working:

```bash
docker container ls --all
docker run --volume $(pwd)/html:/var/www/html --detach --name laravel-landing-cntr-1-2 --publish 8022:22 --publish 8080:80 --publish 8443:443 --publish 9003:9003 --pull=never laravel-landing-img:1.2
docker container ls --all --size
docker exec --interactive --tty --privileged laravel-landing-cntr-1-2 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ip help
ip link
ip address
ip route
ip neigh
tail --follow --lines=20 /var/log/apache2/access.log
tail --follow --lines=20 /var/log/apache2/error.log
exit
```

### login via OpenSSH

I log in from the system that hosts the containers:

```bash
nmap 172.17.0.XXX -Pn -p 22
ssh root@172.17.0.XXX
```

and I try the following command to see if all the expected processes are running:

```bash
ps -eo 'tty,pid,comm' | grep ^?
```

### login from another host

Now I try to log in from the system that hosts the virtual machine that in turn hosts the containers:

```bash
nmap 192.168.1.XXX -Pn -p 8022
ssh root@192.168.1.XXX -p 8022
```

and I can check the use of some tools:

```bash
composer --version
npm -v
node -v
```

### example of sftp.json for `vscode`

```json
{
    "$schema": "http://json-schema.org/draft-07/schema",
    "name": "laravel-landing-cntr-1-2",
    "username": "root",
    "password": "some_password",
    "host": "192.168.1.XXX",
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

```bash
docker stop laravel-landing-cntr-1-2
```

### restart the container

I can proceed to restarting `laravel-landing-cntr-1-2` in privileged mode:

```bash
docker container ls --all
docker start laravel-landing-cntr-1-2
docker exec --interactive --tty --privileged laravel-landing-cntr-1-2 bash
```

## to clean up

### remove container

```bash
docker stop laravel-landing-cntr-1-2 && docker rm laravel-landing-cntr-1-2
docker container ls --all
```

### remove image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
docker image rm laravel-landing-img:1.2
docker images --all
```
