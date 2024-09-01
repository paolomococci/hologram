# `node` and `npm` setup

*However, it is good to remember that it would always be better to obtain information directly from the project website.*

Following are the steps I took to install `node` and `npm` from source code, after reading what was specified on the project website:

```bash
su -
mkdir nodejs && cd nodejs
wget https://nodejs.org/dist/v20.17.0/node-v20.17.0.tar.gz
curl -O https://nodejs.org/dist/v20.17.0/SHASUMS256.txt
ls -l
grep $(sha256sum node-v20.17.0.tar.gz) SHASUMS256.txt
tar -xzf node-v20.17.0.tar.gz
cd node-v20.17.0/
./configure --help
./configure --verbose
make
make install
```

## check

To check the installation:

```bash
npm -v
node -v
```

## update

Later, when I need to update to the latest release:

```bash
node -v
npm view node version
npm cache clean -f
npm install -g n
n stable
npm -v
npm view npm version
npm install -g npm@latest
```
