# web server setup

## parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[national_acronym]
[state]
[city]
posts-php84.local
posts-php84.local
posts-php84.local
[webmaster@localhost]
```

It is obvious that the first three parameters must be appropriately valued.

Therefore I can proceed with the generation of the self-signed certificate without the passphrase thanks to the `-nodes` flag:

```bash
su -
ls -al /etc/ssl/
openssl req -new -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/posts-php84.key -out /etc/ssl/certs/posts-php84.crt
ls -al /etc/ssl/private/ | grep posts
ls -al /etc/ssl/certs/ | grep posts
```

### file `/etc/httpd/conf.d/posts-php84.local.conf`

```bash
nano /etc/httpd/conf.d/posts-php84.local.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName posts-php84.local
        ServerAlias www.posts-php84.local
        DocumentRoot /var/www/html/posts/public
        Redirect permanent "/" "https://posts-php84.local/"
</VirtualHost>

<VirtualHost *:443>
        ServerAdmin webmaster@localhost
        ServerName posts-php84.local
        ServerAlias www.posts-php84.local
        DocumentRoot /var/www/html/posts/public

        <Directory /var/www/html/posts/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        SSLEngine on

        SSLCertificateFile /etc/ssl/certs/posts-php84.crt
        SSLCertificateKeyFile /etc/ssl/private/posts-php84.key

        ErrorLog /var/log/httpd/posts-php84_error_log

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
# Virtual Hosting on hologram-php84.local
#...
192.168.XXX.84  posts-php84.local       www.posts-php84.local
#...
```
