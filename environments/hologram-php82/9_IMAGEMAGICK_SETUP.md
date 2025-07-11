# install `ImageMagick` from source

This procedure can be useful if, for example, you want to use PHP in an LMS environment, (Learning Management System).

## install `openjdk`, `wkhtmltopdf` and `ghostscript`

```bash
apt-get install -y openjdk-17-jdk wkhtmltopdf ghostscript
```

## install `MathJax`

```bash
npm i -g mathjax @types/mathjax
```

## install `ImageMagick`

```bash
wget --spider --https-only https://imagemagick.org/archive/ImageMagick.tar.gz
wget --https-only https://imagemagick.org/archive/ImageMagick.tar.gz
ls -l
sha256sum ImageMagick.tar.gz
tar -xzf ImageMagick.tar.gz
ls -l
cd ImageMagick-7.1.1-47
./configure --with-modules --with-rsvg --with-gslib --with-fpx --with-flif --with-fftw
make
make check
make install
```

## install `imagick`

```bash
git clone https://github.com/Imagick/imagick.git
ls -al
cd imagick/
phpize
./configure
make
make test
make install
```

Now I need to identify the directory where PHP expects to find the extensions:

```bash
php -i | grep extension_dir
```

Once I have found the above directory, I need to copy the file `imagick/modules/imagick.so` into it.

Finally I need to add the following line to the settings file `/opt/php/8.2.29/lib/php.ini`:

```ini
extension="imagick.so"
```

Of course I could open the above `ini` file with a text editor, or I can use the following command:

```bash
sed -i '$aextension="imagick.so"' /opt/php/8.2.29/lib/php.ini
```
