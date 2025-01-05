# setup HTTPS with a self-signed certificate

## to generate a good passphrase I could use the following command:

```bash
pwgen -s 48 1
```

### parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[long_passphrase]
[national_acronym]
[state]
[city]
hologram-php74-vh83.local
hologram-php74-vh83.local
hologram-php74-vh83.local
[webmaster@localhost]
```

Therefore I can proceed with the re-generation of the self-signed certificate:

```bash
ls -al /etc/ssl/self_signed_certs/
sudo openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/hologram-php74-vh83.pem -keyout /etc/ssl/self_signed_certs/hologram-php74-vh83.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/hologram-php74-vh83*
sudo nano /etc/ssl/self_signed_certs/echo_passphrase_vh83.sh
```

```text
#!/bin/sh
echo "long_passphrase"
```

```bash
sudo chmod +x /etc/ssl/self_signed_certs/echo_passphrase_vh83.sh
```

Modify the configuration files so that the web server always responds with the https protocol:

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```xml
<IfModule mod_ssl.c>
    <VirtualHost _default_:443>
        ServerAdmin webmaster@localhost
        ServerName hologram-php74-vh83.local
        ServerAlias www.hologram-php74-vh83.local
        DocumentRoot /var/www/html/vh74

        <Directory /var/www/html/vh74>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/vh74_error.log
        CustomLog ${APACHE_LOG_DIR}/vh74_access.log combined

        SSLEngine on

        SSLCertificateFile /etc/ssl/self_signed_certs/hologram-php74.pem
        SSLCertificateKeyFile /etc/ssl/self_signed_certs/hologram-php74.key

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
    ServerName hologram-php74-vh83.local
    ServerAlias www.hologram-php74-vh83.local
    DocumentRoot /var/www/html/vh74
    Redirect "/" "https://192.168.1.74/"

    <Directory /var/www/html/vh74>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    LogLevel warn

    ErrorLog ${APACHE_LOG_DIR}/vh74_error.log
    CustomLog ${APACHE_LOG_DIR}/vh74_access.log combined
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName www.hologram-php83.local
    ServerAlias hologram-php83.local
    DocumentRoot /var/www/html/vh83

    <Directory /var/www/html/vh83>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    LogLevel warn

    ErrorLog ${APACHE_LOG_DIR}/vh83_error.log
    CustomLog ${APACHE_LOG_DIR}/vh83_access.log combined
</VirtualHost>
```

To work, the newly modified configuration must also have the corresponding setup on the host that runs the virtual machine.

```bash
sudo nano /etc/hosts
```

that is, something similar to the following text should be added:

```text
# local virtual servers for development of web applications
# hologram-php74
192.168.1.74 www.hologram-php74.local
192.168.1.74 hologram-php74.local
192.168.1.74 www.hologram-php83.local
192.168.1.74 hologram-php83.local
```

Now I need to add two lines to the file `/etc/apache2/apache2.conf` file to suppress strange error messages and run the `/etc/ssl/self_signed_certs/echo_passphrase_vh83.sh` script every time I start the Apache web server:

```bash
sudo sed -i '$a#SSLPassPhraseDialog exec:\/etc\/ssl\/self_signed_certs\/echo_passphrase_vh83.sh' /etc/apache2/apache2.conf
tail /etc/apache2/apache2.conf
```

This will avoid having to manually enter the passphrase.
However, this second passphrase is not active.

Finally, activate all necessary modules and restart the web server:

```bash
apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
```
