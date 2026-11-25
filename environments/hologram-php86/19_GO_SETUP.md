# Go programming language setup

To have the development environment on your system you can proceed as follows:

```shell
wget --spider --https-only https://go.dev/dl/go1.25.0.linux-amd64.tar.gz
wget --https-only https://go.dev/dl/go1.25.0.linux-amd64.tar.gz
ls -l
sha256sum go1.25.0.linux-amd64.tar.gz
sudo tar -C /usr/local -xzf go1.25.0.linux-amd64.tar.gz
rm go1.25.0.linux-amd64.tar.gz
export PATH=$PATH:/usr/local/go/bin
go version
nano ~/.bashrc
```

### in case of update

After downloading the archive and verifying it, type:

```shell
sudo rm -rf /usr/local/go && tar -C /usr/local -xzf go1.25.0.linux-amd64.tar.gz
rm go1.25.0.linux-amd64.tar.gz
```
