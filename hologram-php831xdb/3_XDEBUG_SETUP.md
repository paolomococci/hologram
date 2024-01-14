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
