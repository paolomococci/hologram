# `node` and `npm` setup

Following are the steps I took to install `node` and `npm` from source code, after reading what was specified on the project website:

```bash
su -
cd ~ && mkdir nodejs && cd nodejs
wget --spider --https-only https://nodejs.org/dist/v22.11.0/node-v22.11.0.tar.gz
wget --https-only https://nodejs.org/dist/v22.11.0/node-v22.11.0.tar.gz
curl --head https://nodejs.org/dist/v22.11.0/SHASUMS256.txt
curl -O https://nodejs.org/dist/v22.11.0/SHASUMS256.txt
```

I can do the same check in a single command line:

```bash
grep $(sha256sum node-v22.11.0.tar.gz) SHASUMS256.txt
```

and then continue:

```bash
tar -xzf node-v22.11.0.tar.gz
cd node-v22.11.0/
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
