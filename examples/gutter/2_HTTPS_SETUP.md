# https setup a self-signed certificate

## parameter for generate keys:

To generate a good passphrase I could use the following command:

```bash
pwgen -s 48 1
```

```text
[long_passphrase]
[national_acronym]
[state]
[city]
gutter.local
gutter.local
gutter.local
[webmaster@localhost]
```

It is obvious that the first four parameters must be appropriately valued.

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
echo "long_passphrase"
```

or, I can use the `cat` command:

```bash
sudo bash -c 'cat << EOF > /etc/ssl/self_signed_certs/echo_passphrase.sh
#!/bin/sh
echo "long_passphrase"
EOF'
```

Now it is necessary to make the newly created file executable, as well as readable only by the administrator user:

```bash
sudo chmod 700 /etc/ssl/self_signed_certs/echo_passphrase.sh
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

Now I need to add two lines to the file `/etc/apache2/apache2.conf` file to suppress strange error messages and run the `/etc/ssl/self_signed_certs/echo_passphrase.sh` script every time I start the Apache web server:

```bash
sudo nano /etc/apache2/apache2.conf
```

```text
ServerName 127.0.0.1
SSLPassPhraseDialog exec:/etc/ssl/self_signed_certs/echo_passphrase.sh
```

But it is better to modify with sed and then check the result:

```bash
sudo sed -i '$aServerName 127.0.0.1' /etc/apache2/apache2.conf
sudo sed -i '$aSSLPassPhraseDialog exec:/etc/ssl/self_signed_certs/echo_passphrase.sh' /etc/apache2/apache2.conf
tail /etc/apache2/apache2.conf
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
sudo ufw allow from 192.168.1.0/24 proto tcp to any port 443
sudo ufw reload
sudo ufw status numbered
sudo systemctl reload apache2
```
