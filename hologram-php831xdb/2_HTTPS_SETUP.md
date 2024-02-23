# https setup a self-signed certificate

## parameter for generate keys:

To generate a good passphrase I could use the following command:

```bash
pwgen -s 48 1
```

Here is just an example of the parameters to keep on hand:

```text
[long passphrase]
[national_acronym]
[state]
[city]
hologram-php831xdb.local
hologram-php831xdb.local
hologram-php831xdb.local
[webmaster@localhost]
```

Therefore I can proceed with the re-generation of the self-signed certificate:

```bash
ssh developer@192.168.1.138
ls -al /etc/ssl/self_signed_certs/
sudo rm /etc/ssl/self_signed_certs/hologram-php*
sudo openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-php831xdb.pem -keyout /etc/ssl/self_signed_certs/hologram-php831xdb.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/hologram-php831xdb*
sudo nano /etc/ssl/self_signed_certs/echo_passphrase.sh
```

```text
#!/bin/sh
echo "long passphrase"
```

Modify the configuration files so that the web server always responds with the https protocol:

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```text
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName hologram-php831xdb.local
                ServerAlias www.hologram-php831xdb.local
                DocumentRoot /var/www/html/landing/public

                <Directory /var/www/html/landing/public>
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

                SSLCertificateFile /etc/ssl/self_signed_certs/hologram-php831xdb.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/hologram-php831xdb.key

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

```text
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName hologram-php831xdb.local
        ServerAlias www.hologram-php831xdb.local
        DocumentRoot /var/www/html/landing/public
        Redirect "/" "https://192.168.1.138/"

        <Directory /var/www/html/landing/public>
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

Finally:

```bash
sudo systemctl restart apache2
sudo systemctl status apache2
```

