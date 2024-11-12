# `app-fe-cntr-1-0`

```bash
ls ~/projects/apps/app-1.0/frontend/
cd ~/projects/apps/app-1.0/frontend/
```

### solve problems caused by SELinux

The `html` directory can contain either a simple html page or a web application developed using a JavaScript framework.

The best solution in my opinion is to act as the owner of the specific directory:

```bash
mkdir html
ls -lZ
chcon --recursive --type=container_file_t html/
```

### create the container

The `html` directory can contain either a simple html page.

In addition, of course, to all the instructions needed to customize an image and get the container working.

Now I can proceed to create a container starting from the above image in privileged mode:

```bash
podman image list
podman container list --all
podman run --volume $(pwd)/html:/var/www/html --detach --name app-fe-cntr-1-0 --publish 5173:5173 --publish 8090:80 --publish 8444:443 --publish 8021:22 --pull=never  node-app-img:1.0.2
podman container list --all --size
podman exec --interactive --tty --privileged app-fe-cntr-1-0 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ping -c 3 192.168.1.XXX
ip help
ip link
ip address
ip route
ip neigh
tail --follow --lines=20 /var/log/apache2/access.log
tail --follow --lines=20 /var/log/apache2/error.log
exit
```

### login via OpenSSH

Now I try to log in from the system that hosts the virtual machine that in turn hosts the containers:

```bash
nmap 192.168.1.XXX -Pn -p 8021
ssh root@192.168.1.XXX -p 8021
```

### example of sftp.json for `vscode`

```json
{
    "$schema": "http://json-schema.org/draft-07/schema",
    "name": "app-fe-cntr-1-0",
    "username": "root",
    "password": "some_password",
    "host": "192.168.122.221",
    "port": 8021,
    "remotePath": "/var/www/html",
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
        ".docs",
        ".git",
        ".DS_Store",
        "TEMP",
        "nbproject",
        "probe.http"
    ]
}
```

## scaffolding

```bash
cd /var/www/html/
ls -l
rm --recursive landing
npm create vite@latest landing -- --template react
```

Install dependencies:

```bash
cd landing
npm install
```

Add this to `vite.config.js`:

```js
  server: {
    host: true
  },
```

Start development view:

```bash
npm run dev
```

Build dist code:

```bash
npm run build
```

## stop the container

I can use the container name like this:

```bash
podman stop app-fe-cntr-1-0
```

## restart the container

I can proceed to restarting `app-fe-cntr-1-0` in privileged mode:

```bash
podman container list --all
podman start app-fe-cntr-1-0
podman exec --interactive --tty --privileged app-fe-cntr-1-0 bash
```

## remove container

```bash
podman stop app-fe-cntr-1-0 && podman rm app-fe-cntr-1-0
podman container list --all
```
