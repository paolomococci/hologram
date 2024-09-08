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
landing.local
landing.local
landing.local
[webmaster@localhost]
```

It is obvious that the first four parameters must be appropriately valued.

Therefore I can proceed with the re-generation of the self-signed certificate:

```bash
ls -al /etc/ssl/self_signed_certs/
sudo rm /etc/ssl/self_signed_certs/hologram-php*
sudo openssl req -new -x509 -days 365 -out /etc/ssl/self_signed_certs/landing.pem -keyout /etc/ssl/self_signed_certs/landing.key
ls -al /etc/ssl/self_signed_certs/
sudo chmod 600 /etc/ssl/self_signed_certs/landing*
sudo nano /etc/ssl/self_signed_certs/echo_passphrase.sh
```

```text
#!/bin/sh
echo "long passphrase"
```

or, I can use the `cat` command:

```bash
sudo bash -c 'cat << EOF > /etc/ssl/self_signed_certs/echo_passphrase.sh
#!/bin/sh
echo "long passphrase"
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
                ServerName landing.local
                ServerAlias www.landing.local
                DocumentRoot /var/www/html

                <Directory /var/www/html>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                </Directory>

                LogLevel warn

                ErrorLog ${APACHE_LOG_DIR}/landing_error.log
                CustomLog ${APACHE_LOG_DIR}/landing_access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/landing.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/landing.key

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
        ServerName landing.local
        ServerAlias www.landing.local
        DocumentRoot /var/www/html
        Redirect "/" "https://192.168.1.105/"

        <Directory /var/www/html>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        LogLevel warn

        ErrorLog ${APACHE_LOG_DIR}/landing_error.log
        CustomLog ${APACHE_LOG_DIR}/landing_access.log combined
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

Finally:

```bash
apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
sudo systemctl status php-fpm --no-pager
```

## monitoring Apache web server through continuous reading of landing_error.log

```bash
tail -f /var/log/apache2/landing_error.log
```

At this point I happened to still find some errors reported in the log file, one of these simply indicates that a self-signed certificate is being used.

