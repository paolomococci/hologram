# compile OpenSSL version 1.1 from source code

```bash
cd ~
mkdir openssl && cd openssl
wget https://www.openssl.org/source/openssl-1.1.1w.tar.gz
sha256sum openssl-1.1.1w.tar.gz
tar -xf openssl-1.1.1w.tar.gz
cd openssl-1.1.1w/
mkdir build_session && cd build_session
../config --prefix=/opt/openssl/1.1.1w --openssldir=/opt/openssl/1.1.1w/ssl
make
make test
sudo make install
```
