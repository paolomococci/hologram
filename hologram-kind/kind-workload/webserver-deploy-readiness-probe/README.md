# `webserver-deploy-readiness-probe`

## testing a simple web server pod

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
      Lorem ipsum dolor, sit amet consectetur adipisicing elit. Expedita,
      blanditiis quam inventore voluptatem quis quisquam temporibus doloremque
      incidunt corporis laboriosam enim eaque aut veniam quo vel cupiditate
      consectetur at non sequi voluptates ad beatae rerum cum eius! Soluta
      magnam dignissimos, aperiam cumque aliquam, dolorum ab consequatur
      nesciunt dolor doloribus enim itaque animi, quia voluptatem beatae et
      adipisci quos possimus autem. Assumenda tempora voluptates ad consectetur
      architecto, expedita dolorem, eaque rem cupiditate sed consequatur
      aliquam. Autem possimus, ipsam, assumenda ipsa placeat sapiente
      repellendus, laboriosam repudiandae cupiditate cumque iusto necessitatibus
      similique! Sequi vel aperiam sunt fuga odit laborum, velit tempora, quis
      reprehenderit sit cumque, praesentium aliquam nulla soluta. Eveniet
      ratione nisi facere sed fuga molestias modi similique eaque porro unde
      temporibus quod repellat, aliquid tempora cupiditate enim facilis illum,
      ea, quos minima dolor quo repellendus! Nulla eligendi ad, architecto sunt
      temporibus eveniet beatae ipsa tempora repellendus numquam enim illum, sit
      aut ab amet quasi debitis pariatur cum velit! Itaque commodi doloribus,
      repellat nihil hic necessitatibus sint! Debitis, blanditiis cumque
      repellendus voluptatum perferendis nobis hic accusantium id enim eligendi
      odit incidunt voluptate cupiditate illo sequi sit recusandae omnis vero
      magnam! Blanditiis doloremque magnam deserunt temporibus unde error atque
      laudantium assumenda pariatur. Cumque, provident.
    </p>
</body>
</html>
EOF
exit
```

Then I apply the `port forwarding`:

```bash
kubectl port-forward --address 0.0.0.0 pods/nginx-pod 8080:80
```

And I point the browser to the address of the virtual machine hosting the cluster.
To stop port forwarding, simply type the key combination `ctrl+C` within the same terminal.

### delete the pod `nginx-pod`

Typing:

```bash
kubectl delete pods nginx-pod
```

to then check the deletion:

```bash
kubectl get pods
```
