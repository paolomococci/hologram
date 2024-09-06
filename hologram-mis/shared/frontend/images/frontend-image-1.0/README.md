# frontend image version 1.0

First I check that the image does not already exist:

```bash
docker images --all
```

Then I proceed to generate the image `frontend-image`:

```bash
cd /mnt/shared/frontend/images/frontend-image-1.0/
ls -l
cat Dockerfile
docker build --tag frontend-image:1.0 .
docker images --no-trunc --quiet frontend-image:1.0
docker images --all
```

At this point I can paste some web content into directory `/mnt/frontend` and create a volume `frontend-nfs-volume`:

```bash
docker volume ls
```

and, if the volume does not already exist, I will send the following commands:

```bash
docker volume create --driver local --opt type=nfs --opt o=addr="192.168.1.XXX,rw,nfsvers=4" --opt device=:/var/frontend frontend-nfs-volume
docker volume ls
docker volume inspect frontend-nfs-volume
```

I check that there is not already a container with the name of `frontend-nfs-volume`:

```bash
docker container ls --all | grep -i "frontend-container-"
```

Finally, I can create the container that will use the volume `frontend-nfs-volume`, exposing its contents:

```bash
docker run --detach --name frontend-container-1-0 --mount type=volume,source=frontend-nfs-volume,target=/usr/local/apache2/htdocs --publish 8080:80 frontend-image:1.0
docker container ls --all
docker exec --interactive --tty --privileged container_id bash
```

Here I can check the web content from the container shell:

```bash
ls -l /usr/local/apache2/htdocs
exit
```

Now I can make any changes I want to the content, changes that will be immediately reflected in the web content served by the server.

### a further check

Here is a command to try on the client workstation:

```bash
nmap -Pn 192.168.1.XXX -p 8080
```

## final cleaning

### stop of a specific container

Once I have identified the application to stop I can use the ID in the following way:

```bash
docker container ls
docker stop container_id
docker rm container_id
```

### stop all container

```bash
docker stop $(docker ps --quiet)
```

### remove all container

```bash
docker rm $(docker ps --all --quiet)
```

### remove an image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
docker images --all
docker image rm image_id
```

*My data and code will still remain safe in the volume.*

### remove volume `frontend-nfs-volume`

So if I decide to remove the volume as well, the data and/or code will still be safe in the shared directory.

```bash
docker volume ls
docker volume rm frontend-nfs-volume
```

Of course it would be better to always have an indexed backup.
