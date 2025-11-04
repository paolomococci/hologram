# containerization of PHP BFA, (Bellman-Ford Algorithm) development environment

For a `micro-container` oriented architecture.

## firewall setup

Some useful commands for setting up the server firewall that runs the containers.

_Always remember to replace the placeholders that act as the IP address of the server 192.168.XXX.XXX and of the network, 192.168.XXX.0/24 with those available in the real case._

### commands to add IP port 49152

```shell
su -
ss -tuln | grep 49152
firewall-cmd --list-all
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.XXX.0/24" port port=49152 protocol="tcp" accept'
firewall-cmd --reload
firewall-cmd --list-all
```

### to add a port range from 3010 to 3049

```shell
firewall-cmd --zone=public --permanent --add-port=3010-3049/tcp
firewall-cmd --reload
firewall-cmd --list-all
```

### to remove a range of ports from 3010 to 3049

```shell
firewall-cmd --zone=public --permanent --remove-port=3010-3049/tcp
firewall-cmd --reload
firewall-cmd --list-all
```

## local repository

```shell
git init
git branch -m main
git status
git add .
git commit -m "initializing the local repository"
git log
git tag -a v0.0.0 -m "starting version of the microservice"
git checkout -b staging
git checkout -b draft
git merge --no-ff main -m "merge main into draft"
git checkout staging
git merge --no-ff draft -m "merge draft into staging"
git checkout main
git merge --no-ff staging -m "merge staging into main"
git log
git tag -a v1.0.0 -m "first usable version of this microservice"
git branch --list | wc -l
git branch --list
git checkout main
git merge --no-ff draft -m "merge draft into main"
```

## `lamp-bfa-cntr` is an example of use in development sessions

In this example I try to customize an image named `lamp-bfa-img:1.0`

## create an example of container

```shell
ls ~/applications/stacks/LAMP/bfa/
cd ~/applications/stacks/LAMP/bfa/
```

## image build

Once the example web application is built I can issue the following command:

```shell
podman image ls | grep "lamp-bfa-img"
cat Dockerfile
podman build --pull="never" --tag lamp-bfa-img:1.0 .
```

The output of this command should also contain the digest of the newly created local image.

Now I continue with the verification of some details:

```shell
podman image ls | grep "lamp-bfa-img"
podman images --no-trunc --quiet lamp-bfa-img:1.0
podman image inspect lamp-bfa-img:1.0
```

### create the container

The `html` directory contains a simple technical PHP info page, a placeholder. But this time the container has all the tools to develop an application from within and the above mentioned directory serves to make this operation permanent, even after the container is stopped.

Here are all the instructions you need to customize an image and get the container working:

```shell
podman container ls --all
podman run --detach --name lamp-bfa-cntr --publish 49152:49152 --pull="never" lamp-bfa-img:1.0
podman container ls --all --size | grep "lamp-bfa-cntr"
podman exec --interactive --tty --privileged lamp-bfa-cntr sh
```

Start, view logs, stop and delete a container from the command line:

```shell
podman start lamp-bfa-cntr
podman logs --follow=true --color lamp-bfa-cntr
podman stop lamp-bfa-cntr
podman rm lamp-bfa-cntr
```

Integration into a pre-existing pod:

```shell
podman pod start dsa-data-pod
podman run --detach --pod dsa-data-pod --name wp-dsa-bfa --pull="never" lamp-bfa-img:1.0
```

Test operation from inside the pod:

```shell
podman exec -it wp-dsa-app bash
```

Installation of the command necessary to test the functioning of the API:

```shell
apk update
apk add fcgi
```

To then run the actual test of the API that implements the Bellman-Ford Algorithm:

```shell
BODY='{"nodes":["A","B","C","D"],"edges":[["A","B",1],["B","C",2],["A","C",4],["C","D",-3]],"source":"A"}'
export SCRIPT_NAME=/app/index.php
export SCRIPT_FILENAME=/app/index.php
export REQUEST_METHOD=POST
export CONTENT_TYPE='application/json'
export CONTENT_LENGTH=$(printf '%s' "$BODY" | wc -c)
printf '%s' "$BODY" | cgi-fcgi -bind -connect wp-dsa-bfa:49152
```

### container operation checks from a host on the local network

Thanks to `nmap`:

```shell
nmap -Pn 192.168.XXX.XXX -p 49152 | grep "49152/tcp open"
```

Using `nc`:

```shell
nc -vz -w 3 192.168.XXX.XXX 49152 | grep succeeded
```

Graph with four nodes and four edges:

```shell
BODY='{"nodes":["A","B","C","D"],"edges":[["A","B",1],["B","C",2],["A","C",4],["C","D",-3]],"source":"A"}'
export SCRIPT_NAME=/app/index.php
export SCRIPT_FILENAME=/app/index.php
export REQUEST_METHOD=POST
export CONTENT_TYPE='application/json'
export CONTENT_LENGTH=$(printf '%s' "$BODY" | wc -c)
printf '%s' "$BODY" | cgi-fcgi -bind -connect 192.168.XXX.XXX:49152
```

The same graph as above, except for the value assigned to the arc A->C:

```shell
BODY='{"nodes":["A","B","C","D"],"edges":[["A","B",1],["B","C",2],["A","C",2],["C","D",-3]],"source":"A"}'
export SCRIPT_NAME=/app/index.php
export SCRIPT_FILENAME=/app/index.php
export REQUEST_METHOD=POST
export CONTENT_TYPE='application/json'
export CONTENT_LENGTH=$(printf '%s' "$BODY" | wc -c)
printf '%s' "$BODY" | cgi-fcgi -bind -connect 192.168.XXX.XXX:49152
```

A slightly more complex graph with eight nodes and thirteen vertices:

```shell
BODY='{"nodes": ["A","B","C","D","E","F","G","H"],"edges": [["A","B",4],["A","F",7],["B","C",5],["B","D",-2],["C","D",3],["C","E",2],["D","E",4],["D","G",6],["E","F",-3],["F","G",1],["G","H",2],["E","H",5],["C","G",-4]],"source": "A"}'
export SCRIPT_NAME=/app/index.php
export SCRIPT_FILENAME=/app/index.php
export REQUEST_METHOD=POST
export CONTENT_TYPE='application/json'
export CONTENT_LENGTH=$(printf '%s' "$BODY" | wc -c)
printf '%s' "$BODY" | cgi-fcgi -bind -connect 192.168.XXX.XXX:49152
```
