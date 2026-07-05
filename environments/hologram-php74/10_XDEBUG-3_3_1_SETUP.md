# Xdebug setup

## create aliases to PHP 8.3

```bash
sed -i '$a# aliases to PHP 8.3' ~/.bashrc
sed -i '$aalias php83='/opt/php/8.3.2/bin/php'' ~/.bashrc
sed -i '$aalias phpize83='/opt/php/8.3.2/bin/phpize'' ~/.bashrc
. ~/.bashrc
```

## install Xdebug from source

Be sure to replace the real link of the version you prefer.

```bash
cd ~/xdebug
wget https://xdebug.org/files/xdebug-3.3.1.tgz
sha256sum xdebug-3.3.1.tgz
tar -xvzf xdebug-3.3.1.tgz
cd xdebug-3.3.1/
phpize83
mkdir "build_session_$(date +%Y-%m-%d)" && cd "build_session_$(date +%Y-%m-%d)"
../configure --help
../configure --prefix=/opt/php/xdebug/3.3.1 --with-php-config=/opt/php/8.3.2/bin/php-config --enable-xdebug
make
sudo make install
```

## setup of Xdebug

```bash
php --ini
sudo updatedb
locate xdebug.ini
rnano /opt/php/8.3.2/lib/php.ini
```

First it is a good idea to view the contents of the file without risking causing damage.
And now I edit `/opt/php/8.3.2/lib/php.ini` configuration file

```bash
sudo nano /opt/php/8.3.2/lib/php.ini
```

I add this section:

```text
;;;;;;;;;;;;;;;;;;
; Xdebug         ;
;;;;;;;;;;;;;;;;;;

zend_extension=xdebug

; xdebug.mode=[off,develop,coverage,debug,gcstats,profile,trace]
xdebug.mode=debug,trace
xdebug.start_with_request=trigger
xdebug.discover_client_host=1
xdebug.mode=debug
xdebug.client_host=192.168.XXX.XXX
xdebug.client_port=9004
xdebug.connect_timeout_ms=2000
xdebug.idekey=VSCODE
```

After this line:

```text
zend_extension=opcache.so
```

Taking care to replace the 192.168.XXX.XXX placeholder with your IP address.

As can be seen from the last setting I considered using vscode.

Then I have to restart the `PHP-FPM` service

```bash
sudo systemctl reload php-fpm83
sudo systemctl status php-fpm83 --no-pager
php83 -v
```

### on client setup of vscode

Now you need to add file `launch.json` to folder `.vscode`.
Adding the following:

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html/public": "${workspaceFolder}/public",
            }
        }
    ]
}
```

Alright, now you need to be careful when configuring the value of `"pathMappings"`. The first part, `"/var/www/html/public"`, has to precisely match the remote path, while the second part needs to correspond to the code that's written locally, like in example `"${workspaceFolder}/public"`.

## a simple debugging test

Add file `debug.php` to the project, in directory `/var/www/html/public`, by typing the following content:

```php
<?php

declare(strict_types=1); // Enforce strict type checking

// example of debugging an iteration that uses a constant

xdebug_break();

const WELCOME = "Welcome to demo iteration number ";
$sample       = "";

for ($i = 0; $i < 10; $i++) {
    $sample = WELCOME . $i . "!<br>";
    echo $sample;
}
```

Start debugging from `vscode` and, at the same time, point to address <https://192.168.XXX.XXX/debug.php> from the browser.
Attention, remember to replace the placeholder `192.168.XXX.XXX` with your IP address.

Have a good analysis and debugging session.

### a little cunning

Creating a file named `stubs/xdebug.php` in the project's root directory and adding the following content might prevent the code editor from identifying function `xdebug_break()` as unknown and type something similar to the following code:

```php
<?php

declare(strict_types=1); // Enforce strict type checking

if (! function_exists('xdebug_break')) {
    function xdebug_break(): void
    {}
}
```
