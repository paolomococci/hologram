# `ReplicaSet` object example

Create, manage and delete a ReplicaSet object example.

First I need to have a cluster to run the example on.
Then it is good to create the cluster following the procedure indicated in the second part of the `README.md` file contained in the parent directory of this one.

## get cluster name

With the following command I will get, unequivocally, the name of the cluster:

```bash
kind get clusters
```

I will use the cluster name obtained from the previous command to load the custom image present locally, created with the procedure described in the `~/docker-playground/lorem-webserver/README.md` file:

```bash
kind load docker-image lorem-webserver:1.0 --name cluster-one-four
```

Be careful, if you skip this step, when you create the pod you will get an error `ErrImageNeverPull` in column `STATUS` when you request the list of pods.

## `lorem-rs` example

For an example of a set-based selector, I create a ReplicaSet object as follows:

```bash
docker container ls
kubectl config view
kubectl get rs
ls -l ~/kind-workload/lorem-rs/lorem-rs.yaml
kubectl apply -f ~/kind-workload/lorem-rs/lorem-rs.yaml
kubectl describe rs lorem-rs
kubectl get rs -o wide --show-labels
```

To monitor the pod, in a separate terminal, I typed the following command:

```bash
kubectl get pods -o wide --watch
```

## scale replicas

With the following command I can scale from one to two pods:

```bash
kubectl scale rs lorem-rs --replicas=2
kubectl get pods -o wide
kubectl scale rs lorem-rs --replicas=3
kubectl get pods -o wide
kubectl scale rs lorem-rs --replicas=4
kubectl get pods -o wide
```

For testing purposes with the following command I can enable port forwarding rule on one of the two pods:

```bash
kubectl port-forward --address 0.0.0.0 pods/lorem-rs-_____ 8080:80
```

of course, instead of the underscores you should insert the pod identifier generated by the system.
To stop port forwarding rule, simply press ctrl-c in the same terminal from which you issued the previous command.

Finally I delete the ReplicaSet object:

```bash
kubectl scale rs lorem-rs --replicas=1
kubectl get pods
kubectl delete rs lorem-rs
kubectl get rs
```
