# setup HTTPS with a self-signed certificate

## to generate a good passphrase I could use the following command:

```bash
pwgen -s 48 1
```

### parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[long passphrase]
[national_acronym]
[state]
[city]
hologram-bare.local
hologram-bare.local
hologram-bare.local
[webmaster@localhost]
```

Therefore I can proceed with the re-generation of the self-signed certificate:

```bash
ls -al /etc/ssl/self_signed_certs/
sudo rm /etc/ssl/self_signed_certs/hologram-php*
sudo openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-bare.pem -keyout /etc/ssl/self_signed_certs/hologram-bare.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/hologram-bare*
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

```xml
<IfModule mod_ssl.c>
    <VirtualHost _default_:443>
        ServerAdmin webmaster@localhost
        ServerName hologram-bare.local
        ServerAlias www.hologram-bare.local
        DocumentRoot /var/www/html

        <Directory /var/www/html>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/bare_error.log
        CustomLog ${APACHE_LOG_DIR}/bare_access.log combined

        SSLEngine on

        SSLCertificateFile /etc/ssl/self_signed_certs/hologram-bare.pem
        SSLCertificateKeyFile /etc/ssl/self_signed_certs/hologram-bare.key

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
    ServerName hologram-bare.local
    ServerAlias www.hologram-bare.local
    DocumentRoot /var/www/html
    Redirect "/" "https://192.168.1.102/"

    <Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    LogLevel warn

    ErrorLog ${APACHE_LOG_DIR}/bare_error.log
    CustomLog ${APACHE_LOG_DIR}/bare_access.log combined
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

First I checked that some modules are enabled:

```bash
apachectl -M | grep "ssl"
apachectl -M | grep "rewrite"
apachectl -M | grep "headers"
```

Finally, activate all necessary modules and restart the web server:

```bash
sudo a2enmod ssl
sudo a2enmod rewrite
sudo a2enmod headers
apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
```
