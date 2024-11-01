# `agora-qwik-flavor-cntr-1-0`

## create qwik flavor container

```bash
ls ~/projects/apps/agora/agora-1.0/frontend/agora-qwik-flavor-cntr-1-0
cd ~/projects/apps/agora/agora-1.0/frontend/agora-qwik-flavor-cntr-1-0
```

Then I create the directory that will be used to consolidate the volume that will host the container web content and make the source code in it persistent:

```bash
mkdir html && chcon --recursive --type=container_file_t html/ && ls -Z
```

### create the container

The `html` directory can contain either a simple html page.

In addition, of course, to all the instructions needed to customize an image and get the container working.

Now I can proceed to create a container starting from the above image in privileged mode:

```bash
podman container list --all
podman run --volume $(pwd)/html:/var/www/html --detach --name agora-qwik-flavor-cntr-1-0 --publish 5173:5173 --publish 8080:80 --publish 8443:443 --publish 8022:22 --pull=never node-app-img:1.0
podman container list --size
podman exec --interactive --tty --privileged agora-qwik-flavor-cntr-1-0 bash
```

### open a bash shell in the container

Examples of commands typed into container shell:

```bash
ip address
tail --follow --lines=20 /var/log/apache2/access.log
tail --follow --lines=20 /var/log/apache2/error.log
npm -v
npm view npm version
node -v
npm view node version
```

If you need to update:

```bash
npm cache clean -f && npm install -g n && n stable && npm install -g npm@latest
```

Scaffolding:

```bash
cd /var/www/html/
npm create vite@latest landing -- --template qwik
cd landing
npm install
```

Edit `vite.config.js` similar to the following:

```js
import { defineConfig } from 'vite'
import { qwikVite } from '@builder.io/qwik/optimizer'

// https://vite.dev/config/
export default defineConfig({
  server: {
    host: true,
  },
  plugins: [
    qwikVite({
      csr: true,
    }),
  ],
})
```

```bash
npm run dev
exit
```

### login via OpenSSH

Now I try to log in from the system that hosts the virtual machine that in turn hosts the containers:

```bash
nmap 192.168.1.XXX -Pn -p 8022
ssh root@192.168.1.XXX -p 8022
```

### example of sftp.json for `vscode`

```json
{
    "$schema": "http://json-schema.org/draft-07/schema",
    "name": "agora-qwik-flavor-cntr-1-0",
    "username": "root",
    "password": "some_password",
    "host": "192.168.1.XXX",
    "port": 8022,
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

### stop the container

I can use the container name like this:

```bash
podman stop agora-qwik-flavor-cntr-1-0
```

### restart the container

I can proceed to restarting `agora-qwik-flavor-cntr-1-0` in privileged mode:

```bash
podman container list --all
podman start agora-qwik-flavor-cntr-1-0
podman exec --interactive --tty --privileged agora-qwik-flavor-cntr-1-0 bash
```

## to clean up

### remove container

```bash
podman stop agora-qwik-flavor-cntr-1-0 && podman rm agora-qwik-flavor-cntr-1-0
```
