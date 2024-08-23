# `sample-1.0` image

Below is an example of a custom docker image used locally for testing purposes.

```bash
docker version
docker info
ls ~/docker-playground/sample-1.0/
cd ~/docker-playground/sample-1.0/
docker build -t sample:1.0 .
```

The output of this command should also contain the digest of the newly created local image.
The digest will be useful later, during the creation of the replicaset.

I continue with the verification of some details:

```bash
docker images --help
docker images --all
docker images --no-trunc --quiet sample:1.0
```

Optionally I can proceed to create a container starting from the above image:

```bash
docker run --help
docker run -dit --name sample-1.0-app -p 8080:80 sample:1.0
docker container --help
docker container ls --help
docker container ls --all
docker ps --all
```

Once I have identified the application to stop I can use the ID in the following way:

```bash
docker stop `id`
```

## stop all container

```bash
docker stop $(docker ps --quiet)
```

## remove all container

```bash
docker rm $(docker ps --all --quiet)
```

The custom image can be used under certain conditions in a local cluster created by KinD.

## remove an image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
docker image rm `id`
```
