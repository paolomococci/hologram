# `cluster-samples` KinD cluster for a `greeting-job`

## first some checks and then I can create a cluster in declarative mode

Typing:

```bash
cd ~/kind-playground/greeting-job/
kind version
kind get clusters
kind get nodes
ls -l ../kind-cluster-samples.yaml
kind create cluster --config ../kind-cluster-samples.yaml
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

## start pod named `greeting-job` using declarative syntax

Typing:

```bash
kubectl help apply
ls -l ./greeting-job.yaml
kubectl apply -f greeting-job.yaml
```

Now I can read its log with the following command:

```bash
kubectl logs jobs/greeting-job
```

I can use the `watch` flag to update the output of the `kubectl` command:

```bash
kubectl get Pods --watch
```

## delete the pod `greeting-job` manually

But, since I set automatic deletion, this command should not be necessary.

Otherwise, if necessary I can perform the manual deletion with the following command:

```bash
kubectl delete jobs greeting-job
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
