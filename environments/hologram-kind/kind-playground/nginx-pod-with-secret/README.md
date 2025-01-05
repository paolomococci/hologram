# `nginx-pod with secret`

## first some checks and then I can create a cluster in declarative mode

I give the following commands:

```bash
cd ~/kind-playground/nginx-pod-with-secret/
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

## create and delete Opaque type of secret from literal in imperatively mode

```bash
kubectl get secret
kubectl create secret generic secret-opaque-type --from-literal='db_password=some1password'
kubectl get secret
kubectl describe secret secret-opaque-type
kubectl get secret secret-opaque-type -o yaml > secret-opaque-type-dump.yaml
kubectl delete secret secret-opaque-type    
kubectl get secret
```

## create and delete Opaque type of secret from literal in declaratively mode

Small tip, the values ​​reported in the `declarative-secret-opaque-type.yaml` file must be treated similarly in the following way:

```bash
echo 'value to be treated' | base64
```

Now we can proceed:

```bash
kubectl get secret
ls -l declarative-secret-opaque-type.yaml
kubectl apply -f declarative-secret-opaque-type.yaml
kubectl get secret
kubectl describe secret declarative-secret-opaque-type
kubectl get secret declarative-secret-opaque-type -o yaml > declarative-secret-opaque-type-dump.yaml
kubectl delete secret declarative-secret-opaque-type    
kubectl get secret
```

## create a `Secret` from an `.env` file

First I need to create the `.env` file with an example of username, password and role.

Then I can create the object `Secret` starting from `.env`:

```bash
ls -al .env
kubectl create secret generic --help
kubectl create secret generic secret-opaque-type-from-env-file --from-env-file=.env
kubectl get secret
kubectl describe secret secret-opaque-type-from-env-file
kubectl get secret secret-opaque-type-from-env-file -o yaml
kubectl get secret secret-opaque-type-from-env-file -o yaml > secret-opaque-type-from-env-file-dump.yaml
```

## mounts the `Secret` object

Mounts the Secret values ​​on the Pod as if they were files whose content is the setting previously defined as key-value.

```bash
ls -l ./nginx-pod-with-secret.yaml
kubectl apply -f nginx-pod-with-secret.yaml
kubectl get pods
kubectl exec pods/nginx-pod-with-secret -- printenv
```

## delete `nginx-pod-with-secret` and `secret-opaque-type-from-env-file`

```bash
kubectl delete pods nginx-pod-with-secret
kubectl delete secret secret-opaque-type-from-env-file
```

then I make sure that the deletion was successful:

```bash
kubectl get pods
kubectl get secret
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
```
