# web server setup

## parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[national_acronym]
[state]
[city]
chirps-hologram-srv.local
chirps-hologram-srv.local
chirps-hologram-srv.local
[webmaster@localhost]
```

It is obvious that the first three parameters must be appropriately valued.

Therefore I can proceed with the generation of the self-signed certificate without the passphrase thanks to the `-nodes` flag:

```bash
su -
ls -al /etc/ssl/
openssl req -new -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/chirps-hologram-srv.key -out /etc/ssl/certs/chirps-hologram-srv.crt
ls -al /etc/ssl/private/ | grep chirps
ls -al /etc/ssl/certs/ | grep chirps
```

### file `/etc/httpd/conf.d/chirps-hologram-srv.local.conf`

```bash
nano /etc/httpd/conf.d/chirps-hologram-srv.local.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName chirps-hologram-srv.local
        ServerAlias www.chirps-hologram-srv.local
        DocumentRoot /var/www/html/chirps/public
        Redirect permanent "/" "https://chirps-hologram-srv.local/"
</VirtualHost>

<VirtualHost *:443>
        ServerAdmin webmaster@localhost
        ServerName chirps-hologram-srv.local
        ServerAlias www.chirps-hologram-srv.local
        DocumentRoot /var/www/html/chirps/public

        <Directory /var/www/html/chirps/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        SSLEngine on

        SSLCertificateFile /etc/ssl/certs/chirps-hologram-srv.crt
        SSLCertificateKeyFile /etc/ssl/private/chirps-hologram-srv.key

        ErrorLog /var/log/httpd/chirps-hologram-srv_error_log

        <FilesMatch "\.(cgi|shtml|phtml|php)$">
                SSLOptions +StdEnvVars
        </FilesMatch>
</VirtualHost>
```

### application scaffolding

With developer user credentials:

```bash
apachectl configtest
systemctl reload httpd
systemctl status httpd --no-pager
```

If I encounter any problems I can investigate with the following command:

```bash
journalctl -u httpd --since today --no-pager
```

## domain resolution

At this point I will need to set up the resolution of the dummy domain used during the application development.

If you are using a virtual system to host your web server, you may just need to edit the `/etc/hosts` file:

```bash
nano /etc/hosts
```

as shown in the following example:

```text
# Virtual Hosting on local server hologram-srv.local
#...
192.168.XXX.84  chirps-hologram-srv.local       www.chirps-hologram-srv.local
#...
```
