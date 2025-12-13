# development of `opificium` web application

## first scaffold

```shell
cd /var/www/html/
composer create-project laravel/laravel opificium
cd opificium/
chmod --recursive 775 bootstrap/cache && chmod --recursive 775 storage && chmod --recursive 775 database
chown --recursive developer_username:apache .
```

### parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[national_acronym]
[state]
[city]
opificium.local
opificium.local
opificium.local
[webmaster@localhost]
```

It is obvious that the first three parameters must be appropriately valued.

Therefore I can proceed with the generation of the self-signed certificate without the passphrase thanks to the `-nodes` flag:

```shell
ls -al /etc/ssl/
sudo openssl req -new -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/opificium.key -out /etc/ssl/certs/opificium.crt
sudo ls -al /etc/ssl/private/
sudo ls -al /etc/ssl/certs/
```

### file `/etc/httpd/conf.d/opificium.local.conf`

```shell
sudo nano /etc/httpd/conf.d/opificium.local.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName opificium.local
        ServerAlias www.opificium.local
        DocumentRoot /var/www/html/opificium/public
        Redirect permanent "/" "https://opificium.local/"
</VirtualHost>

<VirtualHost *:443>
        ServerAdmin webmaster@localhost
        ServerName opificium.local
        ServerAlias www.opificium.local
        DocumentRoot /var/www/html/opificium/public

        <Directory /var/www/html/opificium/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
                DirectoryIndex index.php
        </Directory>

        SSLEngine on

        SSLCertificateFile /etc/ssl/certs/opificium.crt
        SSLCertificateKeyFile /etc/ssl/private/opificium.key

        ErrorLog /var/log/httpd/opificium_error_log

        <FilesMatch "\.(cgi|shtml|phtml|php)$">
                SSLOptions +StdEnvVars
        </FilesMatch>
</VirtualHost>
```

### application scaffolding

With developer user credentials:

```shell
sudo apachectl configtest
sudo systemctl reload httpd
systemctl status httpd --no-pager
```

If I encounter any problems I can investigate with the following command:

```shell
tail -n 5 /var/log/httpd/hologram-php85_error_log
```

If you receive reports about file permission issues, you can proceed with the following commands:

```shell
sudo chmod -R 755 /var/www/html/opificium/public/
sudo chmod -R 644 /var/www/html/opificium/public/*.php
restorecon -Rv /var/www/html/opificium/
systemctl restart httpd
systemctl status httpd --no-pager
```
