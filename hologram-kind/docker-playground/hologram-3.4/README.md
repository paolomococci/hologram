# `hologram-3.4` how to customize an image named `hologram-mariadb-img:3.4`

*At this stage I create an image that serves as a starting point for further developments, as the approach is to proceed step by step towards the final result.*

Below is an example of how to customize a Docker image used locally for testing purposes, capable of serving web content over the HTTPS protocol.
I will probably use this image as a basis for more and more complex images in the future.

## create an example of container

Below I will use `img` as an abbreviation for image and `cntr` as an abbreviation for container.

```bash
ls ~/docker-playground/hologram-3.4
cd ~/docker-playground/hologram-3.4
```

### image build

Once the example web application is built I can issue the following command:

```bash
docker images --all
cat Dockerfile
docker build --tag hologram-mariadb-img:3.4 .
```

The output of this command should also contain the digest of the newly created local image.

I continue with the verification of some details:

```bash
docker images --all
docker images --no-trunc --quiet hologram-mariadb-img:3.4
docker image inspect hologram-mariadb-img:3.4
```

### MariaDB configuration parameters

First I generate two seventy-nine character passwords:

```bash
pwgen -s 79 2
```

*name of database:*         landing-cntr-3-4

*name of developer user:*   developer-cntr-3-4:

*password of user:*         seventy-nine_character_password

*password of root:*         seventy-nine_character_password

Then I create the directory that will be used to consolidate the volume that will host the container database and make the data in it persistent:

```bash
mkdir data
```

### create the container

I can proceed to create a container starting from the above image in privileged mode:

```bash
docker container ls --all
docker run --volume $(pwd)/data:/var/lib/mysql --detach --name hologram-mariadb-cntr-3-4 --env MARIADB_USER=developer-cntr-3-4 --env MARIADB_PASSWORD=seventy-nine_character_password --env MARIADB_DATABASE=landing-cntr-3-4 --env MARIADB_ROOT_PASSWORD=seventy-nine_character_password --publish 3306:3306 --pull=never hologram-mariadb-img:3.4
docker container ls --all --size
docker exec --interactive --tty --privileged hologram-mariadb-cntr-3-4 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ip help
ip link
ip address
ip route
ip neigh
exit
```

Now I can access the database and data in any way I like.

### stop the container

I can use the container name like this:

```bash
docker stop hologram-mariadb-cntr-3-4
```

### restart the container

I can proceed to restarting `hologram-mariadb-cntr-3-4` in privileged mode:

```bash
docker container ls --all
docker start hologram-mariadb-cntr-3-4
docker exec --interactive --tty --privileged hologram-mariadb-cntr-3-4 bash
```

## to clean up

### remove container

```bash
docker stop hologram-mariadb-cntr-3-4 && docker rm hologram-mariadb-cntr-3-4
```

### remove image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
docker image rm hologram-mariadb-img:3.4
```

I'm checking to make sure I've cleaned up:

```bash
docker container ls --all
docker images --all
```
