# `cluster-samples` KinD cluster with a Pod

## first some checks and then I can create a cluster in declarative mode

Typing:

```bash
kind version
kind get clusters
kind get nodes
kind create cluster --config ./kind-cluster-samples.yaml
kubectl cluster-info --context kind-cluster-samples
```

## check the number of nodes in the cluster

Typing:

```bash
kind get clusters
docker container ls
kubectl get nodes
```

Remember, to access into a cluster, you need to know the location of the cluster and have credentials to access it.

```bash
kubectl config view
```

## start pod named `nginx-pod` using declarative syntax

Typing:

```bash
kubectl help apply
ls -l ./nginx-pod.yaml
kubectl apply --filename=nginx-pod.yaml
```

## listing the Pods

Typing:

```bash
kubectl get Pods
```

or in wide mode:

```bash
kubectl get Pods -o wide
```

Listing the object in yaml format:

```bash
kubectl get Pods nginx-pod -o yaml
```

or, run the following command to get a dump:

```bash
kubectl get Pods nginx-pod -o yaml > nginx-pod-dump.yaml
```

## port forwarding

Typing:

```bash
kubectl port-forward --address 0.0.0.0 Pods/nginx-pod 8080:80
```

## entering into the container inside `nginx-pod`:

Typing:

```bash
kubectl exec -ti nginx-pod -- bash
```

or:

```bash
kubectl exec -ti nginx-pod -- /bin/bash
```

## delete the pod `nginx-pod`

Typing:

```bash
kubectl delete Pods nginx-pod
```

to then check the deletion:

```bash
kubectl get Pods
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
kind get nodes
```
