# `nginx-pod with mounted secret`

## first some checks and then I can create a cluster in declarative mode

I give the following commands:

```bash
cd ~/kind-playground/nginx-pod-with-mounted-secret/
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

Small tip, the values ​​reported in the `declarative-secret-opaque-type.yaml` file must be treated similarly in the following way:

```bash
echo 'value to be treated' | base64
```

Now we can proceed:

```bash
kubectl get secret
kubectl create secret generic imperative-mounted-secret --from-literal='db_password=some1password'
kubectl get secret
kubectl describe secret imperative-mounted-secret
kubectl get secret imperative-mounted-secret -o yaml > imperative-mounted-secret-dump.yaml
kubectl delete secret imperative-mounted-secret    
kubectl get secret
```

## create and delete Opaque type of secret from literal in declaratively mode

```bash
ls -l declarative-mounted-secret.yaml
kubectl apply -f declarative-mounted-secret.yaml
kubectl get secret
kubectl describe secret declarative-mounted-secret
kubectl get secret declarative-mounted-secret -o yaml > declarative-mounted-secret-dump.yaml
kubectl delete secret declarative-mounted-secret    
kubectl get secret
```

## create a `Secret` from an `.env` file

First I need to create the `.env` file with an example of username, password and role.

Then I can create the object `Secret` starting from `.env`:

```bash
ls -al .env
kubectl create secret generic mounted-secret --from-env-file=.env
kubectl get secret
kubectl describe secret mounted-secret
kubectl get secret mounted-secret -o yaml > mounted-secret-dump.yaml
```

## mounts the `Secret` object

Mounts the Secret values ​​on the Pod as if they were files whose content is the setting previously defined as key-value.

```bash
ls -l ./nginx-pod-with-mounted-secret.yaml
kubectl apply -f nginx-pod-with-mounted-secret.yaml
kubectl get pods
kubectl exec pods/nginx-pod-with-mounted-secret -- ls -l /etc/conf/
kubectl exec pods/nginx-pod-with-mounted-secret -- awk 'NR==1' /etc/conf/username
kubectl exec pods/nginx-pod-with-mounted-secret -- awk 'NR==1' /etc/conf/password
kubectl exec pods/nginx-pod-with-mounted-secret -- awk 'NR==1' /etc/conf/role
kubectl get pods nginx-pod-with-mounted-secret -o yaml
kubectl get pods nginx-pod-with-mounted-secret -o yaml > nginx-pod-with-mounted-secret-dump.yaml
```

## delete `nginx-pod-with-mounted-secret` and `mounted-secret`

```bash
kubectl delete pods nginx-pod-with-mounted-secret
kubectl delete secret mounted-secret
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
