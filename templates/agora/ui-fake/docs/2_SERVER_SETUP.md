# web server setup

## parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[national_acronym]
[state]
[city]
ui-fake.local
ui-fake.local
ui-fake.local
[webmaster@localhost]
```

It is obvious that the first three parameters must be appropriately valued.

Therefore I can proceed with the generation of the self-signed certificate without the passphrase thanks to the `-nodes` flag:

```bash
su -
ls -al /etc/ssl/
openssl req -new -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ui-fake.key -out /etc/ssl/certs/ui-fake.crt
ls -al /etc/ssl/private/ | grep ui-fake
ls -al /etc/ssl/certs/ | grep ui-fake
```

### file `/etc/httpd/conf.d/ui-fake.local.conf`

```bash
nano /etc/httpd/conf.d/ui-fake.local.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName ui-fake.local
        DocumentRoot /var/www/html/agora-project/ui-fake/dist
        Redirect permanent "/" "https://ui-fake.local/"
</VirtualHost>

<VirtualHost *:443>
        ServerAdmin webmaster@localhost
        ServerName ui-fake.local
        DocumentRoot /var/www/html/agora-project/ui-fake/dist

        <Directory /var/www/html/agora-project/ui-fake/dist>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        SSLEngine on

        SSLCertificateFile /etc/ssl/certs/ui-fake.crt
        SSLCertificateKeyFile /etc/ssl/private/ui-fake.key

        ErrorLog /var/log/httpd/ui-fake_error_log

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
192.168.XXX.XXX  ui-fake.local
#...
```
