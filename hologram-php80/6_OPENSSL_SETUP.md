# compile OpenSSL version 1.1 from source code

```bash
cd ~
mkdir openssl && cd openssl
wget https://www.openssl.org/source/openssl-1.1.1w.tar.gz
sha256sum openssl-1.1.1w.tar.gz
tar -xf openssl-1.1.1w.tar.gz
cd openssl-1.1.1w/
mkdir build_session && cd build_session
../Configure --prefix=/opt/openssl/1.1.1w --openssldir=/opt/openssl/1.1.1w -fPIC -shared linux-x86_64
make && make test
sudo make install
```

## setup

```bash
sed -i '$aexport PKG_CONFIG_PATH=/opt/openssl/1.1.1w/lib/pkgconfig' ~/.bashrc
sed -i '$aexport OPENSSL_CONF=/usr/lib/ssl/openssl.cnf' ~/.bashrc
tail ~/.bashrc
. ~/.bashrc
printenv | grep "PKG_CONFIG_PATH"
printenv | grep "OPENSSL_CONF"
```

The last three commands are used to reload the `.bashrc` file and verify the effective addition of the variables.
