# install and setup `kubectl`

*However, it is good to remember that it would always be better to obtain information directly from the project website.*

## prepare the installation

Verify the installation of the following packages:

```bash
dpkg -l gnupg
```

If one of the above packages is missing, it should be installed promptly, for example:

```bash
su -
apt update
apt install gnupg
```

## download the public signing key

First I will need to check for the presence of the directory `/etc/apt/keyrings/`:

```bash
ls -al /etc/apt/keyrings/
```

and the permissions that characterize it, displayed in octal mode:

```bash
stat --format='%a -> %n' /etc/apt/keyrings/
```

otherwise I will need to create it:

```bash
mkdir -p -m 755 /etc/apt/keyrings
```

If the directory is already present I will be able to download the signing key of Kubernetes package repositories with the following command:

```bash
curl -fsSL https://pkgs.k8s.io/core:/stable:/v1.31/deb/Release.key | gpg --dearmor -o /etc/apt/keyrings/kubernetes-apt-keyring.gpg
```

It is necessary to assign the correct privileges to file `kubernetes-apt-keyring.gpg`, which must be readable by everyone and writable only by root:

```bash
ls -al /etc/apt/keyrings/kubernetes-apt-keyring.gpg
stat --format='%a -> %n' /etc/apt/keyrings/kubernetes-apt-keyring.gpg
```

and if it does not correspond to what is necessary:

```bash
chmod 644 /etc/apt/keyrings/kubernetes-apt-keyring.gpg
```

Now it's time to add the Kubernetes package source:

```bash
echo 'deb [signed-by=/etc/apt/keyrings/kubernetes-apt-keyring.gpg] https://pkgs.k8s.io/core:/stable:/v1.31/deb/ /' | tee /etc/apt/sources.list.d/kubernetes.list
```

And it's also necessary to assign the correct privileges to file `kubernetes.list`, which must be readable by everyone and writable only by root:

```bash
ls -al /etc/apt/sources.list.d/kubernetes.list
stat --format='%a -> %n' /etc/apt/sources.list.d/kubernetes.list
```

and if it does not correspond to what is necessary:

```bash
chmod 644 /etc/apt/sources.list.d/kubernetes.list
```

For the sake of completeness, if you want to display the permissions of a directory recursively as well as octal mode, the following command will be useful:

```bash
find /etc/apt/sources.list.d/ -printf '%m -> %p\n'
```

## update repositories information and install package `kubectl`

```bash
apt update
apt show kubectl
apt show --all-versions kubectl
apt install kubectl
```

Then I read the documents in the directory `/usr/share/doc/kubectl/`:

```bash
exit
ls -al /usr/share/doc/kubectl/
cat /usr/share/doc/kubectl/LICENSE
cat /usr/share/doc/kubectl/README.md
kubectl --help
```
