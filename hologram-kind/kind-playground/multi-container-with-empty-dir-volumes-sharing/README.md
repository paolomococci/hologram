# example of multiple container with a `shared directory`

## first some checks and then I can create a cluster in declarative mode

I give the following commands:

```bash
cd ~/kind-playground/multi-container-with-empty-dir-volumes-sharing-pod/
kind version
kind get clusters
ls -l ~/kind-playground/kind-cluster-samples.yaml
kind create cluster --config ~/kind-playground/kind-cluster-samples.yaml
kubectl cluster-info --context kind-cluster-samples
```

## check the number of nodes in the cluster

I give the following commands:

```bash
kind get clusters
kubectl get nodes
```

Now I can take a look at the cluster configuration:

```bash
kubectl config view
```

## start pod named `multi-container-with-empty-dir-volumes-sharing-pod` using declarative syntax

I give the following commands:

```bash
kubectl help apply
ls -l ./multi-container-with-empty-dir-volumes-sharing-pod.yaml
kubectl apply -f multi-container-with-empty-dir-volumes-sharing-pod.yaml
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
kubectl get pods multi-container-with-empty-dir-volumes-sharing-pod -o yaml
```

or, run the following command to get a dump:

```bash
kubectl get pods multi-container-with-empty-dir-volumes-sharing-pod -o yaml > multi-container-with-empty-dir-volumes-sharing-pod-dump.yaml
kubectl describe pods multi-container-with-empty-dir-volumes-sharing-pod
kubectl describe pods multi-container-with-empty-dir-volumes-sharing-pod > multi-container-with-empty-dir-volumes-sharing-pod-dump.txt
```

I can use the `watch` flag to update the output of the `kubectl` command:

```bash
kubectl get pods --watch
```

## check empty dir volumes sharing

I check the existence of the shared directory:

```bash
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- ls /var
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container busybox-container -- ls /var
```

I try to write and read the contents of a file in the shared directory:

```bash
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- touch /var/shared/greeting.txt
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- ls /var/shared/
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- bash -c 'echo "Hello from this volume sharing!" >> /var/shared/greeting.txt'
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- cat /var/shared/greeting.txt
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container busybox-container -- cat /var/shared/greeting.txt
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

I give the following commands:

```bash
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- cat /usr/local/apache2/htdocs/index.html
kubectl exec multi-container-with-empty-dir-volumes-sharing-pod --container httpd-container -- bash -c 'echo "<html><head><title>Apache web server</title></head><body><h1>Here is the Apache web server displaying a simple static page!</h1></body></html>" > /usr/local/apache2/htdocs/index.html'
kubectl port-forward --address 0.0.0.0 pods/multi-container-with-empty-dir-volumes-sharing-pod 8080:80
```

## delete the pod `multi-container-with-empty-dir-volumes-sharing-pod`

To delete the pod, I give the following command:

```bash
kubectl delete pods multi-container-with-empty-dir-volumes-sharing-pod
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
