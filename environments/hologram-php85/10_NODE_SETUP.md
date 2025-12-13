# `node` and `npm` setup

Following are the steps I took to install `node` and `npm` from source code, after reading what was specified on the project website:

```shell
cd ~ && mkdir nodejs && cd nodejs
wget --spider --https-only https://nodejs.org/dist/v24.11.1/node-v24.11.1.tar.xz
wget --https-only https://nodejs.org/dist/v24.11.1/node-v24.11.1.tar.xz
curl --head https://nodejs.org/dist/v24.11.1/SHASUMS256.txt
curl -O https://nodejs.org/dist/v24.11.1/SHASUMS256.txt
```

I can do the same check in a single command line:

```shell
grep $(sha256sum node-v24.11.1.tar.xz) SHASUMS256.txt
```

and then continue:

```shell
tar -xf node-v24.11.1.tar.xz
cd node-v24.11.1/
./configure --help
./configure --verbose
make
sudo make install
```

## check

To check the installation:

```shell
npm -v
node -v
```

### Install TypeScript, Angular and MathJax

```shell
npm i -g typescript
npm i -g @angular/cli
npm i -g mathjax @types/mathjax
```

## update

Later, when I need to update to the latest release:

```shell
node -v
npm view node version
npm cache clean -f
npm install -g n
n stable
npm -v
npm view npm version
npm install -g npm@latest
```
