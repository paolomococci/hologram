# ImageMagick setup

Side note, It would be a good idea to read the information and procedures listed on the official `ImageMagick` project website.

```shell
cd ~
su -
dnf search epel-release
dnf info epel-release
dnf install epel-release
dnf check-update --refresh
dnf search p7zip
dnf info p7zip
dnf info p7zip-plugins
dnf install p7zip
dnf install p7zip-plugins
exit
mkdir ImageMagick && cd ImageMagick
```

## install ImageMagick from archive

```shell
wget --spider --https-only https://imagemagick.org/archive/ImageMagick.tar.gz
wget --https-only https://imagemagick.org/archive/ImageMagick.tar.gz
tar -xzf ImageMagick.tar.gz
cd ImageMagick-7.1.2-25
./configure --with-modules --with-rsvg --with-gslib --with-fpx --with-flif --with-fftw --verbose
make -j$(nproc)
sudo make install
```

## install ImageMagick from source

```shell
wget --spider --https-only https://github.com/ImageMagick/ImageMagick/releases/download/7.1.2-26/ImageMagick-7.1.2-26.7z
wget --https-only https://github.com/ImageMagick/ImageMagick/releases/download/7.1.2-26/ImageMagick-7.1.2-26.7z
7z x ImageMagick-7.1.2-26.7z
cd ImageMagick-7.1.2-26/
./configure --with-modules --with-rsvg --with-gslib --with-fpx --with-flif --with-fftw --verbose
nproc --all
make -j$(nproc)
sudo make install
```

## install ImageMagick from repository

```shell
git clone --depth 1 --branch main https://github.com/ImageMagick/ImageMagick.git ImageMagick-7.1.2-26
cd ImageMagick-7.1.2-26/
./configure --with-modules --with-rsvg --with-gslib --with-fpx --with-flif --with-fftw --verbose
nproc --all
make -j$(nproc)
sudo make install
```

### install imagick

```shell
cd ..
git clone https://github.com/Imagick/imagick.git
cd imagick
phpize
./configure
make -j$(nproc)
make test
sudo make install
sudo updatedb
locate imagick.so
php -i | grep extension_dir
```

obtain:

```text
extension_dir => /opt/php/8.5.8/lib/php/extensions/debug-zts-20250925 => /opt/php/8.5.8/lib/php/extensions/debug-zts-20250925
```

### configure PHP with imagick

```shell
ls -al /opt/php/8.5.8/lib/php/extensions/debug-zts-20250925
sudo sed -i '$aextension="imagick.so"' /opt/php/8.5.8/lib/php.ini
sudo systemctl restart php-fpm
systemctl status php-fpm --no-pager
```
