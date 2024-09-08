# install `go` programming language

*However, it is good to remember that it would always be better to obtain information directly from the project website.*

If present, I will first have to remove the previous installation of`go` programming language:

```bash
su -
cd /usr/local/
ls go/
```

if it is present:

```bash
rm --recursive go/
```

Actual installation:

```bash
cd ~
mkdir linux_x86-64 && cd linux_x86-64
wget https://go.dev/dl/go1.23.0.linux-amd64.tar.gz
ls -l
sha256sum go1.23.0.linux-amd64.tar.gz
tar --directory /usr/local -xzf go1.23.0.linux-amd64.tar.gz
cd ~
```

Now I need to edit the `.profile` file in both the root home directory and the developer user home directory:

```bash
nano .profile
```

adding the following lines of code:

```text

# go programming language
if [ -d "/usr/local/go/bin" ] ; then
    PATH="/usr/local/go/bin:$PATH"
fi
```

and then reload the settings:

```bash
. ~/.profile
```

and finally, verify correct installation:

```bash
go version
```

In the future, already having a development environment for the `go` programming language I will be able to install a subsequent version directly from source.