# https setup with a self-signed certificate

## parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[long passphrase]
[national_acronym]
[state]
[city]
hologram-php56.local
hologram-php56.local
hologram-php56.local
[webmaster@localhost]
```

To generate a good passphrase I could use the following command:

```bash
tr -dc 'A-Za-z0-9~!@#$%^&*_=+;:,.? ' </dev/urandom | head -c 128; echo
```

Therefore I can proceed with the generation of the self-signed certificate:

```bash
mkdir -p /etc/ssl/self_signed_certs
openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-php56.pem -keyout /etc/ssl/self_signed_certs/hologram-php56.key
ls -al /etc/ssl/self_signed_certs/
chmod 600 /etc/ssl/self_signed_certs/hologram-php56*
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

```text
<IfModule mod_dir.c>
        DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```

Modify the configuration files so that the web server always responds with the https protocol:

```bash
nano /etc/apache2/sites-available/default-ssl.conf
```

```text
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost

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

                SSLCertificateFile /etc/ssl/self_signed_certs/hologram-php56.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/hologram-php56.key

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
nano /etc/apache2/sites-available/000-default.conf
```

```text
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/landing/public
        Redirect "/" "https://192.168.1.56/"

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

Now you need to edit the `/etc/apache2/apache2.conf` file to suppress strange error messages and run the `/etc/ssl/self_signed_certs/echo_passphrase.sh` script every time you start the Apache web server:

```bash
sudo nano /etc/apache2/apache2.conf
```

```text
...
IncludeOptional sites-enabled/*.conf
ServerName 127.0.0.1
SSLPassPhraseDialog exec:/etc/ssl/self_signed_certs/echo_passphrase.sh
...
```

This will avoid having to manually enter the passphrase.

Finally, activate all necessary modules and restart the web server:

```bash
a2enmod ssl
a2enmod rewrite
a2enmod headers
a2ensite default-ssl
apache2ctl configtest
systemctl reload apache2
```
