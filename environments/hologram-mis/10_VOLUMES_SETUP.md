# Docker volumes settings

This web application is structured by three tiers:
- frontend
- backend
- datastore

I'm going to create three shared directories, each dedicated to a different application tier.

Therefore I will have to connect to the aforementioned directories three volumes dedicated to each tier of the application and each tier will correspond to a Docker container to which I will assign the corresponding volume.

## setup of vscode

Edit sftp.json like this:

```json
{
    "$schema": "http://json-schema.org/draft-07/schema",
    "name": "hologram-mis-shared",
    "username": "developer_username",
    "privateKeyPath": "/home/developer_username/.ssh/id_rsa",
    "passphrase": "developer_passphrase",
    "host": "192.168.1.XXX",
    "remotePath": "/mnt",
    "port": 22,
    "connectTimeout": 20000,
    "uploadOnSave": true,
    "watcher": {
        "files": "dist/*.{js,css}",
        "autoUpload": false,
        "autoDelete": false
    },
    "syncOption": {
        "delete": true,
        "update": false
    },
    "ignore": [
        ".vscode",
        ".howto",
        ".git",
        ".DS_Store",
        "TEMP",
        "nbproject",
        "probe.http"
    ]
}
```

## Docker volumes preparatory setup

I verify that there are no custom images, containers and volumes in the system:

```bash
docker images --all
docker container ls --all
docker volume ls
```

I create directories to use for web application development:

```bash
cd /mnt/shared/
ls -l
mkdir -p frontend/images
mkdir -p backend/images
mkdir -p datastore/images
```

### `frontend-nfs-volume` volume setup

First I create what I need to generate the image with a working web server:

```bash
cd frontend/images
echo "# frontend image" > README.md
echo "FROM httpd:2.4.62" > Dockerfile
```

Then I proceed to generate the image `frontend-image`:

```bash
cat Dockerfile
docker build -t frontend-image:1.0 .
docker images --all
```

At this point I can paste some web content into directory `/mnt/frontend` and create a volume `frontend-nfs-volume`:

```bash
docker volume create --driver local --opt type=nfs --opt o=addr="192.168.1.XXX,rw,nfsvers=4" --opt device=:/var/frontend frontend-nfs-volume
docker volume ls
docker volume inspect frontend-nfs-volume
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

## final cleaning

### stop of a specific container

Once I have identified the application to stop I can use the ID in the following way:

```bash
docker container ls
docker stop container_id
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
docker volume rm frontend-nfs-volume
```

Of course it would be better to always have an indexed backup.
