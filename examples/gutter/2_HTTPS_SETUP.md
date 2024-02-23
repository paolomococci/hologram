# https setup a self-signed certificate

## parameter for generate keys:

To generate a good passphrase I could use the following command:

```bash
pwgen -s 48 1
```

```text
[long passphrase]
[national_acronym]
[state]
[city]
gutter.local
gutter.local
gutter.local
[webmaster@localhost]
```

Therefore I can proceed with the re-generation of the self-signed certificate:

```bash
ls -al /etc/ssl/self_signed_certs/
sudo rm /etc/ssl/self_signed_certs/hologram-php831xdb*
sudo openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/gutter.pem -keyout /etc/ssl/self_signed_certs/gutter.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/gutter*
sudo nano /etc/ssl/self_signed_certs/echo_passphrase.sh
```

```text
#!/bin/sh
echo "long passphrase"
```

```bash
sudo chmod +x /etc/ssl/self_signed_certs/echo_passphrase.sh
```

Change the precedence given to index file types:

```bash
sudo nano /etc/apache2/mods-available/dir.conf
```

```xml
<IfModule mod_dir.c>
        DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```

Modify the configuration files so that the web server always responds with the https protocol:

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```xml
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName gutter.local
                ServerAlias www.gutter.local
                DocumentRoot /var/www/html

                <Directory /var/www/html>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                    #Order allow,deny
                    #allow from all
                </Directory>

                #LogLevel info ssl:warn

                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/gutter.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/gutter.key

                <FilesMatch "\.(cgi|shtml|phtml|php)$">
                    SSLOptions +StdEnvVars
                </FilesMatch>

                <Directory /usr/lib/cgi-bin>
                    SSLOptions +StdEnvVars
                </Directory>
        </VirtualHost>
</IfModule>
```

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName gutter.local
        ServerAlias www.gutter.local
        DocumentRoot /var/www/html
        Redirect "/" "https://192.168.1.XXX/"

        <Directory /var/www/html>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
            #Order allow,deny
            #allow from all
        </Directory>

        #LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Finally, activate all necessary modules and restart the web server:

```bash
apache2ctl configtest
sudo systemctl reload apache2
sudo systemctl status apache2 --no-pager
```
