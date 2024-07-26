# install Kind

Install Kind from the release binary:

```bash
su -
mkdir kind-linux && cd kind-linux
curl -Lo ./kind https://kind.sigs.k8s.io/dl/v0.23.0/kind-linux-amd64
chmod 0755 kind
cp kind /usr/local/bin/kind
exit
kind --help
```
