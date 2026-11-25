# setup HTTPS with a self-signed certificate

## install Apache web server

```shell
su -
dnf install httpd mod_ssl
```

## setup of Apache web server

```shell
systemctl status httpd
systemctl enable httpd
systemctl start httpd
systemctl status httpd --no-pager
id $(whoami)
usermod --append --groups apache $(whoami)
```

### parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[national_acronym]
[state]
[city]
hologram-php86.local
hologram-php86.local
hologram-php86.local
[webmaster@localhost]
```

It is obvious that the first three parameters must be appropriately valued.

Therefore I can proceed with the generation of the self-signed certificate without the passphrase thanks to the `-nodes` flag:

```shell
su -
ls -al /etc/ssl/
mkdir /etc/ssl/private
chmod 700 /etc/ssl/private/
openssl req -new -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/hologram-php86.key -out /etc/ssl/certs/hologram-php86.crt
ls -al /etc/ssl/private/
ls -al /etc/ssl/certs/
```

## configure Apache to use SSL

### file `/etc/httpd/conf/httpd.conf`

```shell
sed -i 's/DirectoryIndex index.html/DirectoryIndex index.php index.html/g' /etc/httpd/conf/httpd.conf
sed -i '$aServerName 127.0.0.1' /etc/httpd/conf/httpd.conf
```

### file `/etc/httpd/conf.d/hologram-php86.local.conf`

```shell
nano /etc/httpd/conf.d/hologram-php86.local.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName hologram-php86.local
        ServerAlias www.hologram-php86.local
        DocumentRoot /var/www/html/hologram-php86/public
        Redirect permanent "/" "https://hologram-php86.local/"
</VirtualHost>

<VirtualHost *:443>
        ServerAdmin webmaster@localhost
        ServerName hologram-php86.local
        ServerAlias www.hologram-php86.local
        DocumentRoot /var/www/html/hologram-php86/public

        <Directory /var/www/html/hologram-php86/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
                DirectoryIndex index.php index.html
        </Directory>

        SSLEngine on

        SSLCertificateFile /etc/ssl/certs/hologram-php86.crt
        SSLCertificateKeyFile /etc/ssl/private/hologram-php86.key

        ErrorLog /var/log/httpd/hologram-php86_error_log

        <FilesMatch "\.(cgi|shtml|phtml|php|phar)$">
                SSLOptions +StdEnvVars
        </FilesMatch>
</VirtualHost>
```

### make the index page

```shell
nano /var/www/html/hologram-php86/public/index.php
```

```php
<? phpinfo();
```

### config test and reload

```shell
apachectl configtest
systemctl reload httpd
systemctl status httpd --no-pager
```

If I encounter any problems I can investigate with the following command:

```shell
tail -n 5 /var/log/httpd/hologram-php86_error_log
```

If you receive reports about file permission issues, you can proceed with the following commands:

```shell
sudo chmod -R 755 /var/www/html/hologram-php86/public/
sudo chmod -R 644 /var/www/html/hologram-php86/public/*.php
sudo restorecon -Rv /var/www/html/hologram-php86/
sudo systemctl restart httpd
systemctl status httpd --no-pager
```
