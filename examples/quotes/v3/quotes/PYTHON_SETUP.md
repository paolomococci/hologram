# Python dev tools setup

First I had to verify the installation of the following packages:

```bash
dpkg -l libncurses5-dev
dpkg -l libgdbm-dev
dpkg -l libnss3-dev
dpkg -l libreadline-dev
dpkg -l libxi-dev
dpkg -l libglew-dev
dpkg -l glew-utils
```

and then install them:

```bash
sudo apt install libncurses5-dev libgdbm-dev libnss3-dev libreadline-dev libxi-dev libglew-dev glew-utils
```

Then I had to download and compile the version I chose:

```bash
mkdir python && cd python
wget https://www.python.org/ftp/python/3.12.4/Python-3.12.4.tar.xz
md5sum Python-3.12.4.tar.xz
tar -xvf Python-3.12.4.tar.xz
cd Python-3.12.4/
mkdir build_session && cd build_session
../configure --help
../configure --prefix=/opt/python/3.12.4 --with-openssl=/usr/bin/openssl --enable-big-digits --enable-ipv6 --enable-optimizations
sudo make altinstall
```

I edited the file `.profile`:

```bash
nano ~/.profile
```

I added this version to the path:

```text
# set PATH so it includes optional python 3.12.4 version
if [ -d "/opt/python/3.12.4/bin" ] ; then
    PATH="/opt/python/3.12.4/bin:$PATH"
fi
```

and finally, I gave the following commands to make the use of this programming language available:

```bash
. ~/.profile
sudo update-alternatives --install /usr/local/bin/python python /opt/python/3.12.4/bin/python3.12 110
update-alternatives --display python
```

One last thing, if over time I have more than one version, I can choose which one to use with the following command:

```bash
sudo update-alternatives --config python
```
