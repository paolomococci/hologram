# the Users application backend

Backend developed in Go programming language, to then be containerized for maximum flexibility and minimal footprint.

## create an example of container

```shell
ls -al ~/applications/stacks/PGF/users/Backend/v1/
cd ~/applications/stacks/PGF/users/Backend/v1/
```

## compiling the `go.sum` file

```shell
cd src/
go mod tidy
```

## image build

Once the example web application is built I can issue the following command:

```shell
cd ~/applications/stacks/PGF/users/Backend/v1/
podman image ls | grep "pgf-users-be-img"
cat Dockerfile
podman build --tag pgf-users-be-img:1.0 .
```

### create the container

Here are all the instructions you need to get the container working:

```shell
podman container ls --all --size | grep "pgf-users-be-cntr"
podman run --detach --name pgf-users-be-cntr-1-0 --publish 8080:8080 --pull=never pgf-users-be-img:1.0
```

### container operation checks from a host on the local network

**Remember to write the actual IP address instead of the placeholder `192.168.XXX.XXX`**

Thanks to `nmap`:

```shell
nmap -Pn 192.168.XXX.XXX -p 8080 | grep "8080/tcp open"
```

Using `nc`:

```shell
nc -vz -w 3 192.168.XXX.XXX 8080 | grep succeeded
```

Using `curl`:

```shell
curl --verbose http://192.168.XXX.XXX:8080/
```

---

## in this case the orchestration provided by `podman` is needed

1. Create the pod (map RESTful API port 8080 on the host):

```shell
cd ~/applications/stacks/PGF/users/Backend/v1/
podman pod create --name pgf-users-pod-1 --publish 8080:8080
```

2. Start PostgreSQL in the pod:

```shell
ls ~/Projects/fullstack-project/pgf/UsersPGF/v1/users/Database
cd ~/Projects/fullstack-project/pgf/UsersPGF/v1/users/Database
podman run --detach --pod pgf-users-pod-1 --name pgf-users-db-cntr --env-file ./env/.env --volume $(pwd)/data:/var/lib/postgresql/18/docker --volume $(pwd)/sql:/docker-entrypoint-initdb.d:ro --pull=never postgres:18.0-alpine3.22
```

3. Verify that the postgres container is running and providing logs:

```shell
podman ps --pod
podman logs -f pgf-users-db-cntr
```

4. Build the API image (assuming the Dockerfile is in the current directory):

```shell
ls -al ~/applications/stacks/PGF/users/Backend/v1/
cd ~/applications/stacks/PGF/users/Backend/v1/
podman build --tag pgf-users-be-img:1.0 .
```

5. Start the API in the pod:

```shell
podman run --detach --pod pgf-users-pod-1 --name pgf-users-be-cntr --pull=never pgf-users-be-img:1.0
```

Note: Containers in the pod share the same loopback network, so the RESTful API can use 127.0.0.1:5432 to connect to Postgres within the same pod.

6. Check that everything is running:

```shell
podman ps --pod
podman logs -f pgf-users-be-cntr
```

7. Optional debugging from the development host:

```shell
nc -vz -w 3 192.168.XXX.XXX 8080 | grep succeeded
```

---

## finally 

Now I can test the API from the shell with the curl program:

```shell
curl --verbose http://192.168.XXX.XXX:8080/users/amelia@example.local
```

And if everything went well I get:

```text
*   Trying 192.168.XXX.XXX:8080...
* Connected to 192.168.XXX.XXX (192.168.XXX.XXX) port 8080 (#0)
> GET /users/amelia@example.local HTTP/1.1
> Host: 192.168.XXX.XXX:8080
> User-Agent: curl/7.88.1
> Accept: */*
> 
< HTTP/1.1 200 OK
< Content-Type: application/json
< Date: Fri, 24 Oct 2025 07:00:33 GMT
< Content-Length: 204
< 
{"id":{"String":"d18d7545-2f9b-4105-9ca7-62a48287f0b6","Valid":true},"name":{"String":"Amelia","Valid":true},"email":{"String":"amelia@example.local","Valid":true},"role":{"String":"admin","Valid":true}}
* Connection #0 to host 192.168.XXX.XXX left intact
```
