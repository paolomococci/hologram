# add support of Xdebug

## make PHP accessible globally not just from Apache

```bash
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.1/bin/php-config /usr/bin/php-config
```

Update `locate` cache:

```bash
sudo updatedb
locate php.ini
```

Side note, if you don't want to continually repeat the `sudo` command and need to issue numerous commands from root, it might be useful to mimic it with the following command:

```bash
sudo -s
```

## install Xdebug from source

Choose the version you deem appropriate which from here on I will exemplify as `xdebug-X.X.X`:

```bash
cd ~
mkdir xdebug && cd xdebug
wget https://xdebug.org/files/xdebug-X.X.X.tgz
sha256sum xdebug-X.X.X.tgz
tar -xvzf xdebug-X.X.X.tgz
cd xdebug-X.X.X/
phpize
mkdir build_session && cd build_session
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
rnano /opt/php/8.3.1/lib/php.ini
```

First it is a good idea to view the contents of the file without risking causing damage.
And now I edit `/opt/php/8.3.1/lib/php.ini` configuration file

```bash
sudo nano /opt/php/8.3.1/lib/php.ini
```

I add this section:

```text
...
;;;;;;;;;;;;;;;;;;
; Xdebug         ;
;;;;;;;;;;;;;;;;;;

zend_extension=xdebug

; xdebug.mode=[off,develop,coverage,debug,gcstats,profile,trace]
xdebug.mode=debug,trace
xdebug.start_with_request=yes
xdebug.discover_client_host=1
xdebug.remote_enable=1
xdebug.client_host=192.168.X.X
xdebug.client_port=9003
xdebug.connect_timeout_ms=2000
xdebug.idekey=VSCODE
...
```

`192.168.X.X` represents the client from which to debug.

As can be seen from the last setting I considered using vscode.

Then I have to restart the `PHP-FPM` service

```bash
sudo systemctl reload php-fpm
sudo systemctl status php-fpm --no-pager
php -v
```

Side note, if you want to avoid receiving excessively verbose messages from `Xdebug` while using Composer's commands it will be useful to modify the line regarding `xdebug.start_with_request` as follows:

```text
xdebug.start_with_request=trigger
```

### setup of vscode

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

Add file `sample.php` to the project, in directory `/var/www/html/landing/public`, by typing the following content:

```php
<?php

for ($i = 0; $i < 10; $i++) {
    $show = $i . "<br>";
    echo $show;
    xdebug_break();
}
```

Start debugging from `vscode` and, at the same time, point to address <https://192.168.1.138/sample.php> from the browser.
Have a good analysis and debugging session.
