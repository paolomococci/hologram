# create and set up some cluster examples

## declarative mode

```bash
mkdir ~/kind-playground && cd ~/kind-playground
```

### `first` cluster example

Four node cluster configuration with one control-plane and three workers:

```bash
mkdir first && cd first
nano kind-cluster-first.yaml
```

and type:

```yaml
kind: Cluster
apiVersion: kind.x-k8s.io/v1alpha4
nodes:
- role: control-plane
- role: worker
- role: worker
- role: worker
```

Or, if you prefer:

```bash
cat <<< 'kind: Cluster
apiVersion: kind.x-k8s.io/v1alpha4
nodes:
- role: control-plane
- role: worker
- role: worker
- role: worker' > kind-cluster-first.yaml
```

Create and delete cluster named `first`:

```bash
kind version
kind --help
kind help get
kind get clusters
kind get nodes
kind help create
kind create cluster --name first --config ./kind-cluster-first.yaml
kubectl cluster-info --context kind-first
kubectl get nodes
kind get clusters
kind help delete cluster
kind delete cluster --name first
cd ..
```
