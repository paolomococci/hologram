# Python3.11 setup

Then I had to download and compile the version I chose:

```bash
mkdir python && cd python
```

Or, if directory `python` already exists:

```bash
cd ~/python
wget --spider --https-only https://www.python.org/ftp/python/3.11.10/Python-3.11.10.tar.xz
wget --https-only https://www.python.org/ftp/python/3.11.10/Python-3.11.10.tar.xz
md5sum Python-3.11.10.tar.xz
tar -xf Python-3.11.10.tar.xz
cd Python-3.11.10/
mkdir build_session_date && cd build_session_date
../configure --help
../configure --enable-big-digits --enable-ipv6 --enable-optimizations
sudo make altinstall
```

Check:

```bash
pip3.11 -V
python3.11 -V
```

## upgrade `pip`

```bash
pip3.11 install --upgrade pip
```
