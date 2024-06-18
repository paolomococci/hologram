# `node` and `npm` setup

Following are the steps I took to install `node` and `npm` from source code, after reading what was specified on the project website:

```bash
cd ~
mkdir nodejs && cd nodejs
wget https://nodejs.org/dist/v20.14.0/node-v20.14.0.tar.gz
curl -O https://nodejs.org/dist/v20.14.0/SHASUMS256.txt
ls -al
sha256sum node-v20.14.0.tar.gz
grep 'the_previously_obtained_alphanumeric_string_must_be_inserted_here' SHASUMS256.txt
tar -xvzf node-v20.14.0.tar.gz
cd node-v20.14.0/
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

## update

Later, when I need to update to the latest release:

```bash
node -v
npm view node version
sudo npm cache clean -f
sudo npm install -g n
sudo n stable
npm -v
npm view npm version
sudo npm install -g npm@latest
```