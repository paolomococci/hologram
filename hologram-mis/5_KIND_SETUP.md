# install Kind

*However, it is good to remember that it would always be better to obtain information directly from the project website.*

Install Kind from the release binary:

```bash
su -
mkdir kind-linux && cd kind-linux
curl -Lo ./kind https://kind.sigs.k8s.io/dl/v0.24.0/kind-linux-amd64
ls -l
chmod 0755 kind
cp kind /usr/local/bin/kind
exit
kind --help
```
