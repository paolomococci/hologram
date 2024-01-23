# Xdebug setup

First, however, it is necessary to make PHP also usable from the command line.

## make PHP accessible globally not just from Apache

```bash
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/php /usr/bin/php
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/phar.phar /usr/bin/phar
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/phpize /usr/bin/phpize
sudo ln --symbolic --verbose /opt/php/8.3.2/bin/php-config /usr/bin/php-config
```

Update `locate` cache:

```bash
sudo updatedb
locate php.ini
```

Side note, if you don't want to continuously repeat the `sudo` command and like me in this case you need to issue numerous commands from root, the following command might be useful:

```bash
sudo -s
```

## install Xdebug from source

Be sure to replace the real link of the version you prefer.

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
make install
```

## setup of Xdebug

```bash
php --ini
updatedb
locate xdebug.ini
rnano /opt/php/8.3.2/lib/php.ini
```

First it is a good idea to view the contents of the file without risking causing damage.
And now I edit `/opt/php/8.3.2/lib/php.ini` configuration file

```bash
nano /opt/php/8.3.2/lib/php.ini
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
xdebug.start_with_request=trigger
xdebug.discover_client_host=1
xdebug.remote_enable=1
xdebug.client_host=192.168.1.1
xdebug.client_port=9003
xdebug.connect_timeout_ms=2000
xdebug.idekey=VSCODE
...
```

As can be seen from the last setting I considered using vscode.

Then I have to restart the `PHP-FPM` service

```bash
sudo systemctl reload php-fpm
sudo systemctl status php-fpm --no-pager
php -v
```
