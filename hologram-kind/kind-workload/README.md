# cluster creation examples

## `kind-cluster-one-two`

KinD, (Kubernetes in Docker), cluster with one control-plane and two worker.

I create the `cluster-one-two`:

```bash
kind get clusters
ls -l ~/kind-workload/kind-cluster-one-two.yaml
kind create cluster --config ~/kind-workload/kind-cluster-one-two.yaml
kubectl cluster-info --context kind-cluster-one-two
```

### some checks

I give the following commands in another terminal:

```bash
kind get clusters
kubectl config view
kubectl get nodes -o wide
kubectl describe nodes
kubectl get sc
kubectl get ns
```

### finally I proceed to delete the example cluster

Finally, I delete the cluster by typing the following commands:

```bash
kind delete cluster --name cluster-one-two
```

and I check its actual success:

```bash
kind get clusters
```

## `kind-cluster-one-four`

I create the `cluster-one-four`:

```bash
kind get clusters
ls -l ~/kind-workload/kind-cluster-one-four.yaml
kind create cluster --config ~/kind-workload/kind-cluster-one-four.yaml
kubectl cluster-info --context kind-cluster-one-four
```

### some checks

I give the following commands in another terminal:

```bash
kind get clusters
kubectl config view
kubectl get nodes -o wide
kubectl describe nodes
kubectl get sc
kubectl get ns
```

### finally I proceed to delete the example cluster

Finally, I delete the cluster by typing the following commands:

```bash
kind delete cluster --name cluster-one-four
```

and I check its actual success:

```bash
kind get clusters
```

## `kind-cluster-one-five`

I create the `cluster-one-five`:

```bash
kind get clusters
ls -l ~/kind-workload/kind-cluster-one-five.yaml
kind create cluster --config ~/kind-workload/kind-cluster-one-five.yaml
kubectl cluster-info --context kind-cluster-one-five
```

### some checks

I give the following commands in another terminal:

```bash
kind get clusters
kubectl config view
```

To get a summary of which IP addresses correspond to which nodes:

```bash
kubectl describe nodes | egrep -i "InternalIP: | Hostname:"
```

To see which StorageClass and Namespaces objects already exist and their settings:

```bash
kubectl get sc
kubectl get ns
```

### finally I proceed to delete the example cluster

Finally, I delete the cluster by typing the following commands:

```bash
kind delete cluster --name cluster-one-five
```

and I check its actual success:

```bash
kind get clusters
```
