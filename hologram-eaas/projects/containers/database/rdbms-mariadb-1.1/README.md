# `rdbms-mariadb-1.1` how to customize an image named `rdbms-mariadb-img:1.1`

*At this stage I create an image that serves as a starting point for further developments.*

## create an example of container

Below I will use `img` as an abbreviation for image and `cntr` as an abbreviation for container.

```bash
ls ~/projects/containers/database/rdbms-mariadb-1.1
cd ~/projects/containers/database/rdbms-mariadb-1.1
```

### image build

Once the example web application is built I can issue the following command:

```bash
podman image list
cat Dockerfile
podman build --tag rdbms-mariadb-img:1.1 .
```

The output of this command should also contain the digest of the newly created local image.

I continue with the verification of some details:

```bash
podman image list
podman images --no-trunc --quiet rdbms-mariadb-img:1.1
podman image inspect rdbms-mariadb-img:1.1
podman images --all
```

### MariaDB configuration parameters

First I generate two seventy-nine character passwords:

```bash
date +%s | sha512sum | base64 | head -c 79 ; echo
```

*name of database:*         db-rdbms-mariadb-1-1

*name of developer user:*   user-rdbms-mariadb-1-1

*password of user:*         password_consisting_of_seventy-nine_characters

*password of root:*         password_consisting_of_seventy-nine_characters

### setup SELinux

Then I create the directory that will be used to consolidate the volume that will host the container database and make the data in it persistent:

```bash
mkdir data
ls -lZ
chcon --recursive --type=container_file_t data/
ls -lZ
```

### create the container

I can proceed to create a container starting from the above image in privileged mode:

```bash
podman container list --all
podman run --volume $(pwd)/data:/var/lib/mysql --detach --name rdbms-mariadb-cntr-1-1 --env MARIADB_USER=user-rdbms-mariadb-1-1 --env MARIADB_PASSWORD=password_consisting_of_seventy-nine_characters --env MARIADB_DATABASE=db-rdbms-mariadb-1-1 --env MARIADB_ROOT_PASSWORD=password_consisting_of_seventy-nine_characters --publish 3306:3306 --pull=never rdbms-mariadb-img:1.1
podman container list --all --size
podman exec --interactive --tty --privileged rdbms-mariadb-cntr-1-1 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ip help
ip link
ip address
ip route
ps ax
cat /etc/mysql/mariadb.conf.d/50-server.cnf | grep bind-address
exit
```

Now I can access the database and data in any way I like.

### stop the container

I can use the container name like this:

```bash
podman stop rdbms-mariadb-cntr-1-1
```

### restart the container

I can proceed to restarting `rdbms-mariadb-cntr-1-1` in privileged mode:

```bash
podman container list --all
podman start rdbms-mariadb-cntr-1-1
podman exec --interactive --tty --privileged rdbms-mariadb-cntr-1-1 bash
```

## to clean up

### remove container

```bash
podman stop rdbms-mariadb-cntr-1-1 && podman rm rdbms-mariadb-cntr-1-1
podman container list --all
```

### remove image

How to remove the custom image in question once I'm done testing or when I have an updated version.

```bash
podman image rm rdbms-mariadb-img:1.1
podman image list
```
