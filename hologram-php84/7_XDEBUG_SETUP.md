# Xdebug setup

Side note, if you don't want to continuously repeat the `sudo` command and like me in this case you need to issue numerous commands from root, the following command might be useful:

```bash
cd ~
su -
```

First, however, it is necessary to make PHP also usable from the command line.

## make PHP accessible globally not just from Apache

Quick warning, if the following links are already there, you will need to remove them first. To then recreate new ones that point to the newly installed versions.

```bash
rm /usr/bin/php
rm /usr/bin/phar
rm /usr/bin/phpize
rm /usr/bin/php-config
```

Otherwise, if this is the first installation from sources, we immediately move on to the following instructions:

```bash
ln --symbolic --verbose /opt/php/8.4.1/bin/php /usr/bin/php
ln --symbolic --verbose /opt/php/8.4.1/bin/phar.phar /usr/bin/phar
ln --symbolic --verbose /opt/php/8.4.1/bin/phpize /usr/bin/phpize
ln --symbolic --verbose /opt/php/8.4.1/bin/php-config /usr/bin/php-config
```

## install Xdebug from source

Be sure to replace the real link of the version you prefer.

```bash
mkdir xdebug && cd xdebug
wget --spider --https-only https://xdebug.org/files/xdebug-3.4.0.tgz
wget --https-only https://xdebug.org/files/xdebug-3.4.0.tgz
sha256sum xdebug-3.4.0.tgz
tar -xvzf xdebug-3.4.0.tgz
ls -l
cd xdebug-3.4.0/
phpize
mkdir build_session_date && cd build_session_date
../configure --help
../configure --prefix=/opt/php/xdebug --enable-xdebug
make
make install
```

Instead, if it is a PHP version update:

```bash
cd xdebug/xdebug-3.4.0/
phpize
mkdir build_session_update_n && cd build_session_update_n
../configure --help
../configure --prefix=/opt/php/xdebug --enable-xdebug
make
make install
```

## setup of Xdebug

```bash
php --ini
updatedb
locate xdebug.ini
rnano /opt/php/8.4.1/lib/php.ini
```

First it is a good idea to view the contents of the file without risking causing damage.
And now I edit `/opt/php/8.4.1/lib/php.ini` configuration file

```bash
nano /opt/php/8.4.1/lib/php.ini
```

I add this section:

```text
...
;;;;;;;;;;;;;;;;;;
; Xdebug         ;
;;;;;;;;;;;;;;;;;;

zend_extension=xdebug

; xdebug.mode=[off,develop,coverage,debug,gcstats,profile,trace]
xdebug.mode=develop,debug,trace,coverage
xdebug.cli_color=1
xdebug.start_with_request=trigger
xdebug.discover_client_host=1
xdebug.remote_enable=1
xdebug.client_host=192.168.1.1
xdebug.client_port=9003
xdebug.connect_timeout_ms=2000
xdebug.idekey=VSCODE
...
```

After this line:

```text
zend_extension=opcache.so
```

As can be seen from the last setting I considered using vscode.

Then I have to restart the `PHP-FPM` service

```bash
systemctl reload php-fpm
systemctl status php-fpm --no-pager
php -v
exit
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
            "port": 9003
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 0,
            "runtimeArgs": [
                "-dxdebug.start_with_request=yes"
            ],
            "env": {
                "XDEBUG_MODE": "debug,develop",
                "XDEBUG_CONFIG": "client_port=${port}"
            }
        },
        {
            "name": "Launch Built-in web server",
            "type": "php",
            "request": "launch",
            "runtimeArgs": [
                "-dxdebug.mode=debug",
                "-dxdebug.start_with_request=yes",
                "-S",
                "localhost:0"
            ],
            "program": "",
            "cwd": "${workspaceRoot}",
            "port": 9003,
            "serverReadyAction": {
                "pattern": "Development Server \\(http://localhost:([0-9]+)\\) started",
                "uriFormat": "http://localhost:%s",
                "action": "openExternally"
            }
        }
    ]
}
```

## a simple debugging test

Add file `sample.php` to the project, in directory `/var/www/html`, by typing the following content:

```php
<?php

// example of debugging an iteration that uses a constant

const WELCOME = "Welcome to demo iteration number ";
$sample = "";

for ($i = 0; $i < 10; $i++) {
    xdebug_break();
    $sample = WELCOME . $i . "!<br>";
    echo $sample;
}

```

Start debugging from `vscode` and, at the same time, point to address <https://192.168.1.84/sample.php> from the browser.
Have a good analysis and debugging session.
