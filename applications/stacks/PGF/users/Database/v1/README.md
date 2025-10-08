# application Users data stored in RDBMS PostgreSQL 18

Internet application data stored in a containerized database server PostgreSQL.

## firewall check

Before starting, it is necessary to make sure that port 5432 of the server where it will turn the container is open:

```shell
su -
firewall-cmd --list-all
```

If not, it will be necessary to give root the commands:

```shell
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.XXX.0/24" port port=5432 protocol="tcp" accept'
firewall-cmd --reload
firewall-cmd --list-all
```

Of course, make sure you select the right network address.

## create an example of container

```shell

ls ~/applications/stacks/PGF/users/Database/v1/
cd ~/applications/stacks/PGF/users/Database/v1/
```

Adapt the directory `data` for use with containers:

```shell
mkdir data sql
chcon --recursive --type=container_file_t ./data/
ls -ldZ ./data/
nano ./sql/init.sh
```

The script`./sql/init.sh` it is used to create a new database, a new schema, a new table and, finally, to populate it with data for the sole purpose of testing.
Then we continue by making the script executable and the directory that contains it suitable for use in a container.

```shell
chmod +x ./sql/init.sh
chcon --recursive --type=container_file_t ./sql/
ls -ldZ ./sql/
```

Attention, if the `data` directory exists the `./sql/init.sh` script already exists will not be performed!

If you want to start over, you will first have to delete directory `./data`:

```shell
sudo rm -Rf data/
mkdir data
chcon --recursive --type=container_file_t ./data/
ls -ldZ ./data/
```

### create the container

The `data` directory contains a permanent data store.

Here are all the instructions you get the container working:

```shell
podman container ls --all
podman run --env-file ./env/.env --volume $(pwd)/data:/var/lib/postgresql/18/docker --volume $(pwd)/sql:/docker-entrypoint-initdb.d:ro --detach --name pgf-users-db-cntr-1-0 --publish 5432:5432 --pull=never postgres:18.0-alpine3.22
```

to then do some checks:

```shell
podman container ls --all --size
podman exec --interactive --tty --privileged pgf-users-db-cntr-1-0 /bin/bash
```

### open a shell shell in the container

Examples of commands that can be typed in the container shell to verify the proper functioning of the service:

```shell
ip help
ip link
ip address
ip route
ps aux | grep postgres
postgres --version psql --version
nc -vz 127.0.0.1 5432
exit
```

### some commands to execute on the host hosting the container

```shell
podman ps --filter "name=pgf-users-db-cntr-1-0" --format "table {{.Names}}\t{{.Ports}}"
```

must return: `0.0.0.0:5432->5432/tcp`.

### some commands to be executed from another host

```shell
nmap -Pn -p 5432 -v 192.168.XXX.XXX
nc -vz -w 3 192.168.XXX.XXX 5432
```

Of course it is necessary to replace network addresses with the actual ones.
