# compile OpenSSL version 1.1 from source code

```bash
cd ~
mkdir openssl && cd openssl
wget https://www.openssl.org/source/openssl-1.1.1w.tar.gz
sha256sum openssl-1.1.1w.tar.gz
tar -xf openssl-1.1.1w.tar.gz
cd openssl-1.1.1w/
mkdir "build_session_$(date +%Y-%m-%d)" && cd "build_session_$(date +%Y-%m-%d)"
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
```

This last command is used to reload the `.bashrc` file.
