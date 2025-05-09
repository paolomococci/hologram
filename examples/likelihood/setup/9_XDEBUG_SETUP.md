# Xdebug setup

## install Xdebug from source

Be sure to replace the real link of the version you prefer.

```bash
cd ~ && mkdir xdebug && cd xdebug
wget https://xdebug.org/files/xdebug-3.3.2.tgz
sha256sum xdebug-3.3.2.tgz
tar -xzf xdebug-3.3.2.tgz
cd xdebug-3.3.2/
phpize
mkdir build_session && cd build_session
../configure --help
../configure --prefix=/opt/php/xdebug --enable-xdebug
make
sudo make install
```

Instead, if it is an update:

```bash
cd xdebug/xdebug-3.3.2/
phpize
mkdir build_session_update_n && cd build_session_update_n
../configure --help
../configure --prefix=/opt/php/xdebug --enable-xdebug
make
sudo make install
```

## setup of Xdebug

```bash
php --ini
sudo updatedb
locate xdebug.ini
rnano /opt/php/8.3.8/lib/php.ini
```

First it is a good idea to view the contents of the file without risking causing damage.
And now I edit `/opt/php/8.3.8/lib/php.ini` configuration file

```bash
sudo nano /opt/php/8.3.8/lib/php.ini
```

I add this section:

```text
;;;;;;;;;;;;;;;;;;
; Xdebug         ;
;;;;;;;;;;;;;;;;;;

zend_extension=xdebug

; xdebug.mode=[off,develop,coverage,debug,gcstats,profile,trace]
xdebug.mode=develop,debug,trace
xdebug.cli_color=1
xdebug.start_with_request=trigger
xdebug.discover_client_host=1
xdebug.remote_enable=1
xdebug.client_host=192.168.1.XXX
xdebug.client_port=9003
xdebug.connect_timeout_ms=2000
xdebug.idekey=VSCODE
```

After this line:

```text
zend_extension=opcache.so
```

As can be seen from the last setting I considered using vscode.

Then I have to restart the `PHP-FPM` service

```bash
sudo systemctl reload php-fpm
systemctl status php-fpm --no-pager
php -v
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
                "/var/www/html": "${workspaceFolder}/html",
            }
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

for ($i = 0; $i < 10; $i++) {
    $show = $i . "<br>";
    echo $show;
    xdebug_break();
}
```

Start debugging from `vscode` and, at the same time, point to address <https://192.168.1.83/sample.php> from the browser.
Have a good analysis and debugging session.
