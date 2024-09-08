# `hologram-frontend-1.0` customized image

Below is an example of how to customize a Docker image used locally for testing purposes, capable of serving web content over the HTTPS protocol.

## create an example of container

```bash
ls ~/docker-playground/hologram-frontend-1.0
cd ~/docker-playground/hologram-frontend-1.0
```

First I will need to create the settings files and web content in their respective directories.
The same files and directories that will be used in the `COPY` commands expressed in `Dockerfile`.
Including self-signed certificates, generated, for example, as follows:

```bash
mkdir self-signed-certificates && cd self-signed-certificates
openssl req -new -x509 -days 365 -out hologram-frontend-one.pem -keyout hologram-frontend-one.key
cd ..
```

Here is just an example of the parameters to keep on hand:

```text
[long passphrase]
[national_acronym]
[state]
[city]
hologram-frontend-one.local
hologram-frontend-one.local
hologram-frontend-one.local
[webmaster@localhost]
```

It is obvious that the first four parameters must be appropriately valued.

A short script `echo_passphrase.sh` similar to the following must be written in directory `self-signed-certificates`:

```text
#!/bin/sh
echo "long passphrase"
```

A directory must be created `mods-available` with a file inside named `dir.conf` containing text similar to the following:

```conf
<IfModule mod_dir.c>
        DirectoryIndex index.html index.cgi index.pl index.xhtml index.htm index.php
</IfModule>
```

A directory must be created `sites-available` with a file inside named `default-ssl.conf` containing the text:

```conf
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName hologram-frontend-one.local
                ServerAlias www.hologram-frontend-one.local
                DocumentRoot /var/www/html

                <Directory /var/www/html>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                </Directory>

                LogLevel warn

                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/hologram-frontend-one.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/hologram-frontend-one.key

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

```conf
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName hologram-frontend-one.local
        ServerAlias www.hologram-frontend-one.local
        DocumentRoot /var/www/html

        <Directory /var/www/html>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

The `dist` directory can contain either a simple html page or a web application developed using a JavaScript framework.

In addition, of course, to all the instructions needed to customize an image and get the container working.

### image build

Once the example web application is built I can issue the following command:

```bash
cat Dockerfile
docker build -t hologram-frontend:1.0 .
```

The output of this command should also contain the digest of the newly created local image.

I continue with the verification of some details:

```bash
docker images --all
docker images --no-trunc --quiet hologram-frontend:1.0
```

### create the container

I can proceed to create a container starting from the above image in privileged mode:

```bash
docker ps --all
docker run --detach --name hologram-frontend-one --publish 8443:443 hologram-frontend:1.0
docker container ls --all --size
docker exec --interactive --tty --privileged hologram-frontend-one bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ping -c 3 192.168.1.XXX
ip help
ip link
ip address
ip route
ip neigh
tail --follow --lines=20 /var/log/apache2/access.log
tail --follow --lines=20 /var/log/apache2/error.log
btop --utf-force
exit
```

### stop the container

I can use the container name like this:

```bash
docker stop hologram-frontend-one
```

### restart the container

I can proceed to restarting `hologram-frontend-one` in privileged mode:

```bash
docker ps --all
docker start hologram-frontend-one
docker exec --interactive --tty --privileged hologram-frontend-one bash
```

## to clean up

### remove container

```bash
docker stop hologram-frontend-one && docker rm hologram-frontend-one
```

### remove image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
docker image rm hologram-frontend:1.0
```

I'm checking to make sure I've cleaned up:

```bash
docker ps --all
docker images --all
```
