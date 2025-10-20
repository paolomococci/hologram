# the Users application backend, a starting point

Version zero, so to speak, developed for illustrative purposes only.

## create an example of container

```shell
ls ~/applications/stacks/PGF/users/Backend/v0/
cd ~/applications/stacks/PGF/users/Backend/v0/
```

## image build

Once the example web application is built I can issue the following command:

```shell
podman image ls | grep "my-hello-img"
cat Dockerfile
podman build --tag my-hello-img:1.0 .
```

### create the container

Here are all the instructions you need to get the container working:

```shell
podman container ls --all --size | grep "my-hello-cntr"
podman run --detach --name my-hello-cntr-1-0 --publish 8080:8080 --pull=never my-hello-img:1.0
```

### container operation checks from a host on the local network

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
curl http://192.168.XXX.XXX:8080/
```

## conclusions

In practice, from an initial image of around 200 MB you move to an intermediate image of just over 300 MB and then conclude the build process with only 5.5 MB of image and not even 2.5 MB at runtime for the container derived from it.
