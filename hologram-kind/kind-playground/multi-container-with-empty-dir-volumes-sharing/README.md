# `cluster-samples` KinD cluster with a Pod

## first some checks and then I can create a cluster in declarative mode

Typing:

```bash
kind version
kind get clusters
ls -l ~/kind-playground/kind-cluster-samples.yaml
kind create cluster --config ~/kind-playground/kind-cluster-samples.yaml
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

## listing the Pods

I can use the `watch` flag to update the output of the `kubectl` command in another virtual terminal:

```bash
kubectl get pods -o wide --show-labels --watch
```

It remains to be considered that the pod `busybox-container` remains active for a few minutes.

## start pod named `multi-container-with-empty-dir-volumes-sharing-pod` using declarative syntax

Typing:

```bash
ls -l ~/kind-playground/multi-container-with-empty-dir-volumes-sharing-pod/multi-container-with-empty-dir-volumes-sharing-pod.yaml
kubectl apply -f ~/kind-playground/multi-container-with-empty-dir-volumes-sharing-pod/multi-container-with-empty-dir-volumes-sharing-pod.yaml
```

## describe the objects:

```bash
kubectl describe pods multi-container-with-empty-dir-volumes-sharing-pod
```

or, run the following command to get a dump:

```bash
kubectl get pods multi-container-with-empty-dir-volumes-sharing-pod -o yaml > multi-container-with-empty-dir-volumes-sharing-pod-dump.yaml
kubectl describe pods multi-container-with-empty-dir-volumes-sharing-pod > multi-container-with-empty-dir-volumes-sharing-pod-dump.txt
```

## check empty dir volumes sharing

I check the existence of the shared directory:

```bash
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- ls /var
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container busybox-container -- ls /var
```

I try to write and read the contents of a file in the shared directory:

```bash
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- touch /var/empty-dir-vol/greeting.txt
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- ls /var/empty-dir-vol/
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- bash -c 'echo "Hello from this volume sharing!" >> /var/empty-dir-vol/greeting.txt'
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- cat /var/empty-dir-vol/greeting.txt
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container busybox-container -- cat /var/empty-dir-vol/greeting.txt
```

## entering into the containers inside `multi-container-with-empty-dir-volumes-sharing-pod`:

`httpd-container`:

```bash
kubectl exec -ti multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- bash
```

`busybox-container`:

```bash
kubectl exec -ti multi-container-with-empty-dir-volumes-sharing-pod --container busybox-container -- bash
```

## access to the logs of a specific container

```bash
kubectl logs -f pods/multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container
```

## port forwarding

Typing:

```bash
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- cat /usr/local/apache2/htdocs/index.html
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- bash -c 'echo "<html><head><title>Apache web server</title></head><body><h1>Here is the Apache web server displaying a simple static page!</h1></body></html>" > /usr/local/apache2/htdocs/index.html'
kubectl port-forward --address 0.0.0.0 pods/multi-container-with-empty-dir-volumes-sharing-pod 8080:80
```

## delete the pod `multi-container-with-empty-dir-volumes-sharing-pod`

Typing:

```bash
kubectl delete pods multi-container-with-empty-dir-volumes-sharing-pod
```

In the other terminal I can see the pods ending their lifecycle.

## delete the cluster

Finally, I delete the cluster by typing the following commands:

```bash
kind delete cluster --name cluster-samples
```

and I check its actual success:

```bash
kind get clusters
```
