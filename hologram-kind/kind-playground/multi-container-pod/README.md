# `multi container pod`

## first some checks and then I can create a cluster in declarative mode

I give the following commands:

```bash
cd ~/kind-playground/multi-container-pod/
kind version
kind get clusters
kind get nodes
ls -l ~/kind-playground/kind-cluster-samples.yaml
kind create cluster --config ~/kind-playground/kind-cluster-samples.yaml
kubectl cluster-info --context kind-cluster-samples
```

## check the number of nodes in the cluster

I give the following commands:

```bash
kind get clusters
docker container ls
kubectl get nodes
```

Now I can take a look at the cluster configuration.

```bash
kubectl config view
```

## start pod named `multi-container-pod` using declarative syntax

I give the following commands:

```bash
kubectl help apply
ls -l ./multi-container-pod.yaml
kubectl apply -f multi-container-pod.yaml
```

## listing the Pods

I give the following command:

```bash
kubectl get pods
```

or in wide mode:

```bash
kubectl get pods -o wide --show-labels
```

Listing the object in yaml format:

```bash
kubectl get pods multi-container-pod -o yaml
```

or, run the following command to get a dump:

```bash
kubectl get pods multi-container-pod -o yaml > multi-container-pod-dump.yaml
kubectl describe pods multi-container-pod
kubectl describe pods multi-container-pod > multi-container-pod-dump.txt
```

I can use the `watch` flag to update the output of the `kubectl` command:

```bash
kubectl get pods --watch
```

## entering into the containers inside `multi-container-pod`:

`httpd-container`:

```bash
kubectl exec -ti multi-container-pod --container httpd-container -- bash
```

`busybox-container`:

```bash
kubectl exec -ti multi-container-pod --container busybox-container -- bash
```

## access to the logs of a specific container

```bash
kubectl logs -f pods/multi-container-pod --container httpd-container
```

## port forwarding

I give the following command:

```bash
kubectl port-forward --address 0.0.0.0 pods/multi-container-pod 8080:80
```

## delete the pod `multi-container-pod`

I give the following command:

```bash
kubectl delete pods multi-container-pod
```

to then check the deletion:

```bash
kubectl get pods
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
