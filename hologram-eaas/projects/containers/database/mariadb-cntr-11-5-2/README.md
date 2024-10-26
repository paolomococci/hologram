# RDBMS container named `mariadb-cntr-11-5-2`

## create an example of container

Below I will use `cntr` as an abbreviation for container.

```bash
ls -al ~/projects/containers/database/mariadb-cntr-11-5-2
cd ~/projects/containers/database/mariadb-cntr-11-5-2
ls -alZ
```

### MariaDB configuration parameters

First I generate three character passwords:

```bash
date +%s | sha512sum | base64 | head -c 79 ; echo
```

*name of database:*         landing-mariadb-11-5-2

*name of developer user:*   dev-mariadb-11-5-2

*password of user:*         password_consisting_of_seventy-nine_characters

*password of root:*         password_consisting_of_seventy-nine_characters

### directory `data` setup

Then I create the directory that will be used to consolidate the volume that will host the container database and make the data in it persistent:

```bash
mkdir data
ls -Z
chcon --recursive --type=container_file_t data/
ls -Z
```

### create the container

I can proceed to create a container starting:

```bash
podman container list --all
podman run --volume $(pwd)/data:/var/lib/mysql --detach --name mariadb-cntr-11-5-2 --env MARIADB_USER=dev-mariadb-11-5-2 --env MARIADB_PASSWORD=password_consisting_of_seventy-nine_characters --env MARIADB_DATABASE=landing-mariadb-11-5-2 --env MARIADB_ROOT_PASSWORD=password_consisting_of_seventy-nine_characters --publish 3306:3306 mariadb:11.5.2
podman container list --size
podman exec --interactive --tty --privileged mariadb-cntr-11-5-2 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ip help
ip link
ip address
ip route
ps ax
mariadbd --print-defaults
my_print_defaults --mysqld
ls -l /etc/mysql/my.cnf
cat /etc/mysql/my.cnf
exit
```

Now I can access the database and data in any way I like.

### stop the container

I can use the container name like this:

```bash
podman stop mariadb-cntr-11-5-2
```

### restart the container

I can proceed to restarting `mariadb-cntr-11-5-2` in privileged mode:

```bash
podman container list --all
podman start mariadb-cntr-11-5-2
podman exec --interactive --tty --privileged mariadb-cntr-11-5-2 bash
```

## to clean up

### remove container

```bash
podman stop mariadb-cntr-11-5-2 && podman rm mariadb-cntr-11-5-2
podman container list --all
```
