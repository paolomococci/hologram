# `lorem-pod`

How to use a custom docker image built locally to get a working pod.

## some checks and then I can create a cluster in declarative mode

I type the following commands:

```bash
kind version
ls ~/kind-playground/lorem-pod/
cd ~/kind-playground/lorem-pod/
ls -l ../kind-cluster-samples.yaml
kind create cluster --config ../kind-cluster-samples.yaml
kubectl cluster-info --context kind-cluster-samples
```

## check the number of nodes in the cluster

To do this I can type the following commands:

```bash
kubectl config view
docker container ls
```

With the following command I will get, unequivocally, the name of the cluster:

```bash
kind get clusters
```

## load the local docker image `lorem-webserver` into the `cluster-samples`

I will use the cluster name obtained from the previous command to load the custom image present locally, created with the procedure described in the `~/docker-playground/lorem-webserver/README.md` file:

```bash
kind load docker-image lorem-webserver:1.0 --name cluster-samples
```

Be careful, if you skip this step, when you create the pod you will get an error `ErrImageNeverPull` in column `STATUS` when you request the list of pods.

## start pod named `lorem-pod` using declarative syntax

To monitor the pod, in a separate terminal, I typed the following command:

```bash
kubectl get pods -o wide --watch
```

Now I can type the following commands:

```bash
ls -l ./lorem-pod.yaml
kubectl apply -f ./lorem-pod.yaml
```

Listing the pod object in yaml format:

```bash
kubectl get pod lorem-pod -o yaml
```

or, run the following command to get a dump:

```bash
kubectl get pod lorem-pod -o yaml > lorem-pod-dump.yaml
```

## port forwarding

To do the port forwarding I can type the following command:

```bash
kubectl port-forward --address 0.0.0.0 pods/lorem-pod 8080:80
```

## view content of `index.html` inside `lorem-pod`:

To do this I can type the following command:

```bash
kubectl exec -ti lorem-pod -- cat /usr/local/apache2/htdocs/index.html
```

## delete the pod `lorem-pod`

I can type the following command:

```bash
kubectl delete pod lorem-pod
```

to then check the deletion:

```bash
kubectl get pods
```

## delete the cluster

Finally, I delete the cluster by typing the following commands:

```bash
kind delete cluster --name cluster-samples
```

and I check its actual success:

```bash
kind get clusters
kind get nodes
```
