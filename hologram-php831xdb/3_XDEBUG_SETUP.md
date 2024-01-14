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
