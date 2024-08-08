# `nginx-pod with mounted configmap`

## first some checks and then I can create a cluster in declarative mode

I give the following commands:

```bash
cd ~/kind-playground/nginx-pod-with-mounted-configmap/
kind get clusters
ls -l ~/kind-playground/kind-cluster-samples.yaml
kind create cluster --config ~/kind-playground/kind-cluster-samples.yaml
kubectl cluster-info --context kind-cluster-samples
```

## check the number of nodes in the cluster

I give the following commands:

```bash
kind get clusters
```

Now I can take a look at the cluster configuration.

```bash
kubectl config view
```

## create a `ConfigMap` from an `.env` file

First I need to create the `.env` file:

```text
# example of .env file
greeting=hello
color=green
version=1.0.0
```

Then I can create the object `ConfigMap` starting from `.env`:

```bash
ls -al .env
kubectl create configmap mounted-configmap --from-env-file=.env
kubectl get configmaps
kubectl describe configmap mounted-configmap
kubectl get configmap mounted-configmap -o yaml
kubectl get configmap mounted-configmap -o yaml > mounted-configmap-dump.yaml
```

## mounts the ConfigMap object

Mounts the ConfigMap values ​​on the Pod as if they were files whose content is the setting previously defined as key-value.

```bash
ls -l ./nginx-pod-with-mounted-configmap.yaml
kubectl apply -f nginx-pod-with-mounted-configmap.yaml
kubectl get pods
kubectl exec pods/nginx-pod-with-mounted-configmap -- ls -l /etc/conf/
kubectl exec pods/nginx-pod-with-mounted-configmap -- awk 'NR==1' /etc/conf/greeting
kubectl exec pods/nginx-pod-with-mounted-configmap -- awk 'NR==1' /etc/conf/color
kubectl exec pods/nginx-pod-with-mounted-configmap -- awk 'NR==1' /etc/conf/version
```

## delete `nginx-pod-with-mounted-configmap` and `mounted-configmap` 

```bash
kubectl delete pods nginx-pod-with-mounted-configmap
kubectl delete configmap mounted-configmap
```

then I make sure that the deletion was successful:

```bash
kubectl get pods
kubectl get configmaps
```

## delete the cluster

Finally, I delete the cluster by typing the following commands:

```bash
kind get clusters
kind help delete cluster
kind delete cluster --name cluster-samples
```

and I check its actual success:

```bash
kind get clusters
```
