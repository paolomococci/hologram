# `rdbms-mariadb-1.0` how to customize an image named `rdbms-mariadb-img:1.0`

*At this stage I create an image that serves as a starting point for further developments, as the approach is to proceed step by step towards the final result.*

I will probably use this image as a basis for more and more complex images in the future.

## create an example of container

Below I will use `img` as an abbreviation for image and `cntr` as an abbreviation for container.

```bash
ls ~/project/templates/database/rdbms-mariadb-1.0
cd ~/project/templates/database/rdbms-mariadb-1.0
```

### image build

Once the example web application is built I can issue the following command:

```bash
docker image ls
cat Dockerfile
docker build --tag rdbms-mariadb-img:1.0 .
```

The output of this command should also contain the digest of the newly created local image.

I continue with the verification of some details:

```bash
docker image ls
docker images --no-trunc --quiet rdbms-mariadb-img:1.0
docker image inspect rdbms-mariadb-img:1.0
docker images --all
```

### MariaDB configuration parameters

First I generate two seventy-nine character passwords:

```bash
pwgen -s 79 2
```

*name of database:*         landing-rdbms-mariadb-1-0

*name of developer user:*   developer-rdbms-mariadb-1-0

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
docker run --volume $(pwd)/data:/var/lib/mysql --detach --name rdbms-mariadb-cntr-1-0 --env MARIADB_USER=developer-rdbms-mariadb-1-0 --env MARIADB_PASSWORD=seventy-nine_character_password --env MARIADB_DATABASE=landing-rdbms-mariadb-1-0 --env MARIADB_ROOT_PASSWORD=seventy-nine_character_password --publish 3306:3306 --pull=never rdbms-mariadb-img:1.0
docker container ls --all --size
docker exec --interactive --tty --privileged rdbms-mariadb-cntr-1-0 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ip help
ip link
ip address
ip route
exit
```

Now I can access the database and data in any way I like.

### stop the container

I can use the container name like this:

```bash
docker stop rdbms-mariadb-cntr-1-0
```

### restart the container

I can proceed to restarting `rdbms-mariadb-cntr-1-0` in privileged mode:

```bash
docker container ls --all
docker start rdbms-mariadb-cntr-1-0
docker exec --interactive --tty --privileged rdbms-mariadb-cntr-1-0 bash
```

## to clean up

### remove container

```bash
docker stop rdbms-mariadb-cntr-1-0 && docker rm rdbms-mariadb-cntr-1-0
```

### remove image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
docker image rm rdbms-mariadb-img:1.0
```

I'm checking to make sure I've cleaned up:

```bash
docker container ls --all
docker images --all
```
