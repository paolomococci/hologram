# `webserver-deploy-readiness-probe`

## first, I test a simple web server pod

To monitor the pod, in a separate terminal, I typed the following command:

```bash
kubectl get pods -o wide --watch
```

### start the pod `nginx-pod`

```bash
ls -l ~/kind-workload/webserver-deploy-readiness-probe/nginx-pod.yaml
kubectl apply -f ~/kind-workload/webserver-deploy-readiness-probe/nginx-pod.yaml
kubectl get pods -o wide --show-labels
kubectl exec -ti nginx-pod -- bash
```

I first issue the following shell commands from inside the container to find out which Linux distribution is in the pod, to confirm the location of the index file, and finally to modify the index file to highlight its IP address:

```bash
uname --all
ls -l /usr/share/nginx/html/
cat > /usr/share/nginx/html/index.html << EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KinD workload</title>
    <style>
        html { color-scheme: light dark; }
        body { width: 35rem; margin: 3rem; font-family: sans-serif; }
        h1, h3 { color: grey; }
        em { color: greenyellow; }
        p { margin-left: 3rem; color: grey; }
    </style>
</head>
<body>
    <h1>Hello from Kubernetes in Docker example!</h1>
    <h3>This content is served from a web server hosted in the pod with IP address: <em>$(hostname -i)</h3>
    <p>
      Lorem ipsum dolor, sit amet consectetur adipisicing elit...
    </p>
</body>
</html>
EOF
```

Then I apply the `port forwarding`:

```bash
kubectl port-forward --address 0.0.0.0 pods/nginx-pod 8080:80
```

And I point the browser to the address of the virtual machine hosting the cluster.
To stop port forwarding, simply type the key combination `ctrl+C` within the same terminal.

### delete the pod `nginx-pod`

```bash
kubectl delete pods nginx-pod
```

to then check the deletion:

```bash
kubectl get pods
```

## second, to get to the heart of this example I can use a `kustomization.yaml` file

```bash
ls -l ~/kind-workload/webserver-deploy-readiness-probe/custom/kustomization.yaml
kubectl apply -k ~/kind-workload/webserver-deploy-readiness-probe/custom/
```

By doing this I do nothing more than apply the manifest files listed in `~/kind-workload/webserver-deploy-readiness-probe/custom/kustomization.yaml`.

### test the Deployment object

To monitor the pod, in a separate terminal, I typed the following command:

```bash
kubectl get pods -o wide --watch
```

```bash
kubectl get deploy
kubectl get svc
kubectl get nodes -o wide
```

Now I consider the node names and IP addresses obtained from the last command.
After choosing one, I type the following commands, remembering that the port number is the one set in the `webserver-svc.yaml` manifest:

```bash
ping -c 3 <ip_node_address>
curl http://<ip_node_address>:31001
```

Well, if for some reason a node should respond to the home page request with an error, it is good to send the same request to another node, which can also be `control-plane`.
However, it would be good to investigate the return of the above error.

### scaling the Deployment object

```bash
kubectl scale deploy webserver-deploy --replicas=3
```

Now I have to simulate a pod failure, choosing the pod previously selected:

```bash
kubectl exec -ti webserver-deploy-__________-_____ -- ls -l /usr/share/nginx/html/probe
kubectl exec -ti webserver-deploy-__________-_____ -- rm /usr/share/nginx/html/probe
```

Here is the following request that returns me an error code:

```bash
curl http://<ip_node_address>:31001/probe
```

After a short while, the damaged pod will no longer be available.

### deleting Service and Deployment objects

```bash
kubectl delete svc webserver-svc
kubectl delete deploy webserver-deploy
kubectl get pods,deploy,svc
```
