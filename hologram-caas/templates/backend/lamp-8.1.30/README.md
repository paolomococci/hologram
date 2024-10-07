# `lamp-8.1.30` how to customize an image named `lamp-img:8.1.30`

*image used as a starting point for further developments, as the approach is to proceed step by step towards the final result*

Below is an example of how to customize a Docker image used locally for testing purposes, capable of serving web content over the HTTPS protocol.
In this case I mean to get an application environment that can execute code written in PHP language.

![info page](screenshots/lamp-cntr-8-1-30_info_page.jpg)

I optimize the screenshot as follows:

```bash
ls -l lamp-cntr-8-1-30_info_page.png
convert lamp-cntr-8-1-30_info_page.png lamp-cntr-8-1-30_info_page.jpg
mogrify -quality 35 lamp-cntr-8-1-30_info_page.jpg
du -h lamp-cntr-8-1-30_info_page*
rm lamp-cntr-8-1-30_info_page.png
identify -verbose lamp-cntr-8-1-30_info_page.jpg
```

## PHP version 8.1.30

Open the following link in your favorite browser:

<https://www.php.net/downloads>

Follow the instructions to download and verify the compressed archive php-8.1.30.tar.xz and finally, place the same archive in the `sources` directory.

## create an example of container

Below I will use `img` as an abbreviation for image and `cntr` as an abbreviation for container.

```bash
ls ~/project/templates/backend/lamp-8.1.30
cd ~/project/templates/backend/lamp-8.1.30
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

### image build

Once the example web application is built I can issue the following command:

```bash
docker image ls
cat Dockerfile
docker build --tag lamp-img:8.1.30 .
```

The output of this command should also contain the digest of the newly created local image.

I continue with the verification of some details:

```bash
docker images --all
docker images --no-trunc --quiet lamp-img:8.1.30
docker image inspect lamp-img:8.1.30
```

### create the container

The `html` directory can contain either a simple html page or a web application developed using a JavaScript framework.

In addition, of course, to all the instructions needed to customize an image and get the container working.

Now I can proceed to create a container starting from the above image in privileged mode:

```bash
docker container ls --all
docker run --volume $(pwd)/html:/var/www/html --detach --name lamp-cntr-8-1-30 --publish 8443:443 --pull=never lamp-img:8.1.30
docker container ls --all --size
docker exec --interactive --tty --privileged lamp-cntr-8-1-30 bash
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
exit
```

### stop the container

I can use the container name like this:

```bash
docker stop lamp-cntr-8-1-30
```

### restart the container

I can proceed to restarting `lamp-cntr-8-1-30` in privileged mode:

```bash
docker container ls --all
docker start lamp-cntr-8-1-30
docker exec --interactive --tty --privileged lamp-cntr-8-1-30 bash
```

## to clean up

### remove container

```bash
docker stop lamp-cntr-8-1-30 && docker rm lamp-cntr-8-1-30
```

### remove image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
docker image rm lamp-img:8.1.30
```

I'm checking to make sure I've cleaned up:

```bash
docker container ls --all
docker image ls
docker ps
```
