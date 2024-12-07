# Python3.12 setup

Then I had to download and compile the version I chose:

```bash
mkdir python && cd python
```

Or, if directory `python` already exists:

```bash
cd ~/python
wget --spider --https-only https://www.python.org/ftp/python/3.12.7/Python-3.12.7.tar.xz
wget --https-only https://www.python.org/ftp/python/3.12.7/Python-3.12.7.tar.xz
md5sum Python-3.12.7.tar.xz
tar -xf Python-3.12.7.tar.xz
cd Python-3.12.7/
mkdir build_session_date && cd build_session_date
../configure --help
../configure --enable-big-digits --enable-ipv6 --enable-optimizations
make
sudo make install
```

I edited the file `.bashrc`:

```bash
nano ~/.bashrc
```

I added this version to the path:

```bash
# aliases
alias python='python3'
alias pip='pip3'
alias idle='idle3'
alias pydoc='pydoc3'
alias python-config='python3-config'
```

Now I have to load the new settings without logging in again:

```bash
. ~/.bashrc
```

Check:

```bash
python -V
pip -V
python --help
pip --help
idle --help
pydoc --help
python-config --help
2to3 --help
```

## upgrade `pip`

```bash
pip3 install --upgrade pip
```
