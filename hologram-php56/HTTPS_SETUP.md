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
tr -dc 'A-Za-z0-9~!@#$%^&*_=+;:,.? ' </dev/urandom | head -c 48; echo
```

Therefore I can proceed with the generation of the self-signed certificate:

```bash
ls -al /etc/ssl/
sudo mkdir -p /etc/ssl/self_signed_certs
sudo chmod 600 /etc/ssl/self_signed_certs/hologram-php*openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-php56.pem -keyout /etc/ssl/self_signed_certs/hologram-php56.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/hologram-php56*
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
sudo nano /etc/apache2/sites-available/default-ssl.conf
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
sudo nano /etc/apache2/sites-available/000-default.conf
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
sudo a2enmod ssl
a2query -m ssl
sudo a2enmod rewrite
a2query -m rewrite
sudo a2enmod headers
a2query -m headers
sudo a2ensite default-ssl
sudo apache2ctl configtest
sudo ufw allow from 192.168.122.0/24 proto tcp to any port 443
sudo ufw reload
sudo ufw status numbered
sudo systemctl reload apache2
```

## `The web server does not start`

Attention, sometimes it may happen that the Apache server does not start correctly and the following warning is found in the error.log file:

```text
...
AH02580: Init: Pass phrase incorrect for key
...
```

First of all, check that the `/etc/ssl/self_signed_certs/echo_passphrase.sh` file contains the correct passphrase and as a last resort you can try to regenerate the self-signed certificates with a new passphrase, perhaps obtained in a different way from the previous one.

Of course there are many other commands that can be used to generate strong passphrases, such as:

```bash
openssl rand -hex 48
openssl rand -base64 48
pwgen -s 48 1
```
