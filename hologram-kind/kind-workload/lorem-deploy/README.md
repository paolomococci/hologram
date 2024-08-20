# `Deployment` object example

Create, manage and delete a Deployment object example.

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

## `lorem-deploy` example

For an example of a set-based selector, I create a Deployment object as follows:

```bash
docker container ls
kubectl config view
kubectl get deploy
ls -l ~/kind-workload/lorem-deploy/lorem-deploy.yaml
kubectl apply -f ~/kind-workload/lorem-deploy/lorem-deploy.yaml
kubectl describe deploy lorem-deploy
kubectl get deploy -o wide --show-labels
kubectl get pods -o wide
```

## scale replicas

With the following command I can scale from one to two pods:

```bash
kubectl scale deploy lorem-deploy --replicas=4
```

## how to expose an application through a Service object of type `NodePort`

Now I want to have only one replica that serves the page `index.html`:

```bash
kubectl scale deploy lorem-deploy --replicas=1
kubectl get nodes -o wide
```

From this last command I can obtain the private IP address of each node in the cluster.

```bash
kubectl get pods -o wide
```

This last command allows me to know on which worker node the pod is running and associate the private IP address to it to be set in the settings file of the Service object that I am about to create, which for example could be similar to the following `lorem-svc.yaml`:

```yaml
apiVersion: v1
kind: Service
metadata:
  name: lorem-svc
  labels:
    app: lorem
spec:
  externalIPs: 
    ## replace the following placeholder with the private IP address of interest
    - 'private_ip_address'
  selector:
    app: lorem
  type: NodePort
  ports:
    - port: 8080
      protocol: TCP
      targetPort: 80

```

Of course, you need to replace the example IP address with your real one.
And then proceed with the creation of the Service object:

```bash
ls -l ~/kind-workload/lorem-deploy/lorem-svc.yaml
kubectl apply -f ~/kind-workload/lorem-deploy/lorem-svc.yaml
kubectl get svc -o wide
```

after having confirmed the IP address in the entry `EXTERNAL-IP` associated with the ports highlighted in `PORT(S)` I can finally request the web page served by the system with a command similar to the following `curl <private_ip_address>:8080`.

## delete service

```bash
kubectl delete svc lorem-svc
kubectl get svc
```

## delete deploy

Finally I delete the Deployment object:

```bash
kubectl delete deploy lorem-deploy
kubectl get deploy
kubectl get pods
```
