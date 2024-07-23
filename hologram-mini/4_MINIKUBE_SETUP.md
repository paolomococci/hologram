# install Minikube

Minikube is a useful tool for testing Kubernetes scenarios without running a multi-node cluster.

## installation thanks to the Debian package

```bash
su -
mkdir extra && cd extra/
curl -LO https://storage.googleapis.com/minikube/releases/latest/minikube_latest_amd64.deb
ls -al
dpkg -i minikube_latest_amd64.deb
dpkg -l minikube
apt show minikube
```

## test local cluster

An non-root user can add an appropriate alias if `kubectl` is not installed on the system:

```bash
sed -i '$a# kubectl alias' ~/.bashrc
sed -i '$aalias kubectl="minikube kubectl --"' ~/.bashrc
tail .bashrc
. ~/.bashrc
```

Now, as a non-root user, I can perform some tests:

```bash
minikube help
minikube help start
minikube start --driver="docker"
minikube status
kubectl config view
kubectl config current-context
kubectl get nodes
kubectl get nodes -o wide
kubectl get cs
minikube pause
minikube status
minikube unpause
minikube status
minikube stop
minikube status
minikube delete
minikube status
```
