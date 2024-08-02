# `cluster-samples` KinD cluster for a `greeting-cronjob`

## first some checks and then I can create a cluster in declarative mode

Typing:

```bash
cd ~/kind-playground/greeting-cronjob/
ls -l ../kind-cluster-samples.yaml
kind create cluster --config ../kind-cluster-samples.yaml
kubectl cluster-info --context kind-cluster-samples
```

## check the number of nodes in the cluster

Typing:

```bash
kubectl config view
kind get clusters
kubectl get nodes
```

To then try to list some specific objects:

```bash
kubectl get pods
kubectl get jobs
kubectl get cronjobs
```

## start pod named `greeting-cronjob` using declarative syntax

Typing:

```bash
kubectl help apply
ls -l ./greeting-cronjob.yaml
kubectl apply -f greeting-cronjob.yaml
kubectl get cronjobs
kubectl describe cronjob greeting-cronjob
```

I can use the `watch` flag to update the output of the `kubectl` command:

```bash
kubectl get pods --watch
```

To view the job result, type the following in another terminal:

```bash
kubectl logs name_of_pod
```

## delete the pod `greeting-cronjob` manually

But, since I set automatic deletion, this command should not be necessary.

Otherwise, if necessary I can perform the manual deletion with the following command:

```bash
kubectl delete cronjob greeting-cronjob
```

to then check the deletion:

```bash
kubectl get pods
```

## delete the cluster

Finally, I delete the cluster by typing the following commands:

```bash
kind get clusters
kind delete cluster --name cluster-samples
```

and I check its actual success:

```bash
kind get clusters
kind get nodes
```
