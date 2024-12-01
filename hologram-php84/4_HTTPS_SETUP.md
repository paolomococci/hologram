# setup HTTPS with a self-signed certificate

## install Apache web server

```bash
su -
dnf install httpd mod_ssl
```

## setup of Apache web server

```bash
systemctl status httpd
systemctl enable httpd
systemctl start httpd
systemctl status httpd --no-pager
```

### parameter for generate keys:

Here is just an example of the parameters to keep on hand:

```text
[national_acronym]
[state]
[city]
hologram-php84.local
hologram-php84.local
hologram-php84.local
[webmaster@localhost]
```

It is obvious that the first three parameters must be appropriately valued.

Therefore I can proceed with the generation of the self-signed certificate without the passphrase thanks to the `-nodes` flag:

```bash
su -
ls -al /etc/ssl/
mkdir /etc/ssl/private
chmod 700 /etc/ssl/private/
openssl req -new -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/hologram-php84.key -out /etc/ssl/certs/hologram-php84.crt
ls -al /etc/ssl/private/
ls -al /etc/ssl/certs/
```

## configure Apache to use SSL

### file `/etc/httpd/conf/httpd.conf`

```bash
sed -i 's/DirectoryIndex index.html/DirectoryIndex index.php index.html/g' /etc/httpd/conf/httpd.conf
sed -i '$aServerName 127.0.0.1' /etc/httpd/conf/httpd.conf
```

### file `/etc/httpd/conf.d/hologram-php84.local.conf`

```bash
nano /etc/httpd/conf.d/hologram-php84.local.conf
```

```xml
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName hologram-php84.local
        ServerAlias www.hologram-php84.local
        DocumentRoot /var/www/html
        Redirect permanent "/" "https://hologram-php84.local/"
</VirtualHost>

<VirtualHost *:443>
        ServerAdmin webmaster@localhost
        ServerName hologram-php84.local
        ServerAlias www.hologram-php84.local
        DocumentRoot /var/www/html

        <Directory /var/www/html>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        SSLEngine on

        SSLCertificateFile /etc/ssl/certs/hologram-php84.crt
        SSLCertificateKeyFile /etc/ssl/private/hologram-php84.key

        <FilesMatch "\.(cgi|shtml|phtml|php|phar)$">
                SSLOptions +StdEnvVars
        </FilesMatch>
</VirtualHost>
```

### make the index page

```bash
nano /var/www/html/index.html
```

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hologram-PHP84</title>
  </head>
  <body>
    <h1>Hologram-PHP84</h1>
    <p>
      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aut earum nihil
      corporis! Rerum sapiente odio illo, sint ipsum tempore placeat ducimus est
      animi fugit. Consequatur eum, repudiandae velit doloremque cum earum
      quidem exercitationem laboriosam cupiditate omnis maxime dicta unde
      consequuntur iure sed pariatur quas. Inventore dolorum quo voluptas
      laboriosam dignissimos exercitationem, iure suscipit debitis hic ut rerum
      expedita voluptates alias perferendis at eligendi repellendus eius officia
      dolor dolore fuga illo quas sit laborum? Delectus, culpa? Nesciunt natus
      repellat enim quas inventore, doloribus consequuntur fugit exercitationem
      voluptates laborum accusamus quidem dolor autem vero. Voluptatem facilis
      sunt harum aut vero tempore placeat dolor dolore officiis id asperiores
      numquam nam labore, dolorem optio assumenda. Repudiandae error quisquam,
      autem quasi expedita molestias mollitia minima esse unde repellat nemo
      neque? Molestias nulla, nesciunt earum inventore libero mollitia, ea alias
      praesentium dolore quam necessitatibus saepe ipsam fuga similique,
      architecto laborum qui tempore maiores! Veritatis, quas? Laudantium quas
      corrupti molestiae unde consequatur consectetur obcaecati sint facilis
      eaque dolore, recusandae ad earum dignissimos fuga? Corporis velit
      accusamus ab architecto asperiores veritatis omnis tenetur eligendi
      explicabo dolorem praesentium assumenda rerum ipsa quis reprehenderit
      dignissimos quam neque voluptatibus, adipisci rem iure voluptas, quia ut
      suscipit. Atque, tempora ipsam deleniti tenetur consectetur officia ut.
      Quaerat, est quia, nihil quidem soluta inventore vitae ipsa, atque
      suscipit ipsam nemo temporibus consectetur ducimus praesentium dolore
      consequuntur qui voluptatem. Earum veniam illum, odio optio non quam.
      Sapiente tenetur odit consequatur? Est repellendus quis animi pariatur
      illo debitis quam odit iure dolores aliquam ducimus possimus doloribus
      reprehenderit dolore officia, incidunt repellat quo eaque officiis
      laboriosam vero aut a hic! Dolore illum nesciunt, alias odit vero a quae
      provident, minus voluptates magnam, ullam similique? Quia temporibus eaque
      enim amet non. Iste natus omnis blanditiis ipsa consequatur itaque vel
      impedit ad quae voluptate ullam eos nam debitis eius porro eum ea eveniet,
      cum libero. Nisi reiciendis voluptates quas officia architecto, nostrum,
      error dolore dolores quisquam veniam rem perferendis! Voluptates, porro
      voluptatum! Omnis similique iusto incidunt sint reprehenderit. Accusamus
      vitae, repellendus tempore similique architecto magnam eaque, itaque
      voluptatem cumque deserunt ut saepe officia! Modi amet, similique qui
      accusamus repellendus consequuntur error voluptates sint consectetur, quis
      ea iusto accusantium veritatis perspiciatis unde numquam blanditiis!
      Fugiat doloribus necessitatibus ipsam voluptas, amet ducimus. Adipisci,
      temporibus minus dolores repellendus doloribus cupiditate accusantium
      voluptas obcaecati? Eius laudantium obcaecati dolor cupiditate hic, eum
      nihil corporis labore autem alias, expedita dolores aliquam neque
      dignissimos nesciunt itaque!
    </p>
    <a href="info.php">info</a>
  </body>
</html>
```

### config test and reload

```bash
apachectl configtest
systemctl reload httpd
systemctl status httpd --no-pager
```

If I encounter any problems I can investigate with the following command:

```bash
journalctl -u httpd --since today --no-pager
```
