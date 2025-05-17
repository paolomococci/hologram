# `node` and `npm` setup

Following are the steps I took to install `node` and `npm` from source code, after reading what was specified on the project website:

```bash
cd ~ && mkdir nodejs && cd nodejs
wget --spider --https-only https://nodejs.org/dist/v22.15.0/node-v22.15.0.tar.xz
wget --https-only https://nodejs.org/dist/v22.15.0/node-v22.15.0.tar.xz
curl --head https://nodejs.org/dist/v22.15.0/SHASUMS256.txt
curl -O https://nodejs.org/dist/v22.15.0/SHASUMS256.txt
```

I can do the same check in a single command line:

```bash
grep $(sha256sum node-v22.15.0.tar.xz) SHASUMS256.txt
```

and then continue:

```bash
tar -xf node-v22.15.0.tar.xz
cd node-v22.15.0/
./configure --help
./configure --verbose
make
sudo make install
```

## check

To check the installation:

```bash
npm -v
node -v
```

### Install TypeScript, Angular and MathJax

```bash
npm i -g typescript
npm i -g @angular/cli
npm i -g mathjax @types/mathjax
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
