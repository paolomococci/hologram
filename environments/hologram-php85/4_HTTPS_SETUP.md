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
id developer_username
usermod --append --groups apache developer_username
```

### parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[national_acronym]
[state]
[city]
hologram-php85.local
hologram-php85.local
hologram-php85.local
[webmaster@localhost]
```

It is obvious that the first three parameters must be appropriately valued.

Therefore I can proceed with the generation of the self-signed certificate without the passphrase thanks to the `-nodes` flag:

```shell
su -
ls -al /etc/ssl/
mkdir /etc/ssl/private
chmod 700 /etc/ssl/private/
openssl req -new -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/hologram-php85.key -out /etc/ssl/certs/hologram-php85.crt
ls -al /etc/ssl/private/
ls -al /etc/ssl/certs/
```

## configure Apache to use SSL

### file `/etc/httpd/conf/httpd.conf`

```shell
sed -i 's/DirectoryIndex index.html/DirectoryIndex index.php index.html/g' /etc/httpd/conf/httpd.conf
sed -i '$aServerName 127.0.0.1' /etc/httpd/conf/httpd.conf
```

### file `/etc/httpd/conf.d/hologram-php85.local.conf`

```shell
nano /etc/httpd/conf.d/hologram-php85.local.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName hologram-php85.local
        ServerAlias www.hologram-php85.local
        DocumentRoot /var/www/html/hologram-php85/public
        Redirect permanent "/" "https://hologram-php85.local/"
</VirtualHost>

<VirtualHost *:443>
        ServerAdmin webmaster@localhost
        ServerName hologram-php85.local
        ServerAlias www.hologram-php85.local
        DocumentRoot /var/www/html/hologram-php85/public

        <Directory /var/www/html/hologram-php85/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
                DirectoryIndex index.php index.html
        </Directory>

        SSLEngine on

        SSLCertificateFile /etc/ssl/certs/hologram-php85.crt
        SSLCertificateKeyFile /etc/ssl/private/hologram-php85.key

        ErrorLog /var/log/httpd/hologram-php85_error_log

        <FilesMatch "\.(cgi|shtml|phtml|php|phar)$">
                SSLOptions +StdEnvVars
        </FilesMatch>
</VirtualHost>
```

### make the index page

```shell
nano /var/www/html/hologram-php85/public/index.php
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
tail -n 5 /var/log/httpd/hologram-php85_error_log
```

If you receive reports about file permission issues, you can proceed with the following commands:

```shell
sudo chmod -R 755 /var/www/html/opificium/public/
sudo chmod -R 644 /var/www/html/opificium/public/*.php
sudo restorecon -Rv /var/www/html/opificium/
sudo systemctl restart httpd
systemctl status httpd --no-pager
```
