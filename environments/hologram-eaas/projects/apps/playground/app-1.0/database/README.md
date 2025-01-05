# `app-db-cntr-1-0`

```bash
ls ~/projects/apps/app-1.0/database/
cd ~/projects/apps/app-1.0/database/
```

### MariaDB configuration parameters

First I generate two seventy-nine character passwords:

```bash
date +%s | sha512sum | base64 | head -c 79 ; echo
```

*name of database:*         app-db-1-0

*name of developer user:*   developer-app-db-1-0

*password of developer:*    developer_password

*password of root:*         root_password

### solve problems caused by SELinux

Then I create the directory that will be used to consolidate the volume that will host the container database and make the data in it persistent:

```bash
sudo semanage fcontext --list | grep container_file_t
mkdir data
ls -lZ
chcon --recursive --type=container_file_t data/
ls -lZ
```

### create the container

I can proceed to create a container starting from the above image in privileged mode:

```bash
podman image list
podman container list --all
podman run --volume $(pwd)/data:/var/lib/mysql --detach --name app-db-cntr-1-0 --env MARIADB_USER=developer-app-db-1-0 --env MARIADB_PASSWORD=developer_password --env MARIADB_DATABASE=app-db-1-0 --env MARIADB_ROOT_PASSWORD=root_password --publish 3306:3306 --pull=never rdbms-mariadb-img:1.0
podman container list --all --size
podman exec --interactive --tty --privileged app-db-cntr-1-0 bash
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
podman stop app-db-cntr-1-0
```

### restart the container

I can proceed to restarting `app-db-cntr-1-0` in privileged mode:

```bash
podman container list --all
podman start app-db-cntr-1-0
podman exec --interactive --tty --privileged app-db-cntr-1-0 bash
```

## to clean up

### remove container

```bash
podman stop app-db-cntr-1-0 && podman rm app-db-cntr-1-0
podman container list --all
```
