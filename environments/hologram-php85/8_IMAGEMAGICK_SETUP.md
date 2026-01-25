# ImageMagick setup

Side note, if you don't want to continuously repeat the `sudo` command and like me in this case you need to issue numerous commands from root, the following command might be useful:

```shell
cd ~
su -
```

## Install ImageMagick

```shell
wget --spider --https-only https://imagemagick.org/archive/ImageMagick.tar.gz
tar -xzf ImageMagick.tar.gz
cd ImageMagick-7.1.2-13
./configure --with-modules --with-rsvg --with-gslib --with-fpx --with-flif --with-fftw --verbose
make && make install
```

### install imagick

```shell
git clone https://github.com/Imagick/imagick.git
cd imagick
phpize
./configure
make && make install
updatedb
locate imagick.so
php -i | grep extension_dir
```

obtain:

```text
extension_dir => /opt/php/8.5.2/lib/php/extensions/debug-zts-20250925 => /opt/php/8.5.2/lib/php/extensions/debug-zts-20250925
```

### configure PHP with imagick

```shell
ls -al /opt/php/8.5.2/lib/php/extensions/debug-zts-20250925
sudo sed -i '$aextension="imagick.so"' /opt/php/8.5.2/lib/php.ini
sudo systemctl restart php-fpm
systemctl status php-fpm --no-pager
```
