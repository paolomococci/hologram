# Python3.13 setup

Then I had to download and compile the version I chose:

```bash
mkdir python && cd python
```

Or, if directory `python` already exists:

```bash
cd ~/python
wget --spider --https-only https://www.python.org/ftp/python/3.13.0/Python-3.13.0.tar.xz
wget --https-only https://www.python.org/ftp/python/3.13.0/Python-3.13.0.tar.xz
md5sum Python-3.13.0.tar.xz
tar -xf Python-3.13.0.tar.xz
cd Python-3.13.0/
mkdir build_session_date && cd build_session_date
../configure --help
../configure --enable-big-digits --enable-ipv6 --enable-optimizations
sudo make altinstall
```

Check:

```bash
pip3.13 -V
python3.13 -V
```

## upgrade `pip`

```bash
pip3.13 install --upgrade pip
```
