# `agora-db-cntr-1-0`

## I prepare the environment

```bash
cd ~
mkdir -p projects/apps/agora/agora-1.0/database/agora-db-cntr-1-0
ls -l projects/apps/agora/agora-1.0/database/agora-db-cntr-1-0
cd projects/apps/agora/agora-1.0/database/agora-db-cntr-1-0
mkdir data && chcon --recursive --type=container_file_t data && ls -lZ
podman image list
```

## I create database container

```bash
podman run --volume $(pwd)/data:/var/lib/mysql \
--detach --name agora-db-cntr-1-0 \
--env MARIADB_USER=agora-db-dev-user-1-0 \
--env MARIADB_PASSWORD=some_password \
--env MARIADB_DATABASE=agora-db-1-0 \
--env MARIADB_ROOT_PASSWORD=some_password \
--publish 3306:3306 \
--pull=never rdbms-mariadb-img:1.1
```

## I check that everything is working correctly

```bash
podman container list --size
podman exec --interactive --tty --privileged agora-db-cntr-1-0 bash
```

## stop the container

I can use the container name like this:

```bash
podman stop agora-db-cntr-1-0
```

## restart the container

I can proceed to restarting `agora-db-cntr-1-0` in privileged mode:

```bash
podman container list --all
podman start agora-db-cntr-1-0
podman exec --interactive --tty --privileged agora-db-cntr-1-0 bash
```

## if necessary I remove the container

```bash
podman stop agora-db-cntr-1-0 && podman rm agora-db-cntr-1-0
podman container list --all
```
