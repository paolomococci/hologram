# document root tuning

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```xml
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName hologram-bare.local
                ServerAlias www.hologram-bare.local
                DocumentRoot /var/www/html/sample/public

                <Directory /var/www/html/sample/public>
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
        DocumentRoot /var/www/html/sample/public
        Redirect "/" "https://192.168.1.102/"

        <Directory /var/www/html/sample/public>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/bare_error.log
        CustomLog ${APACHE_LOG_DIR}/bare_access.log combined
</VirtualHost>
```

```bash
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
```
