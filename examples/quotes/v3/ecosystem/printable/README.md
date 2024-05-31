# printable

## scaffolding

On the server, starting from my home directory:

```bash
mkdir -p webapps/vue
cd webapps/vue/
npm create vue@latest
cd printable/
npm install
```

## prepare environment for developing and preview

```bash
sudo ufw status verbose
sudo ufw status numbered
sudo ufw allow from 192.168.1.0/24 proto tcp to any port 8080
sudo ufw status numbered
sudo ufw reload
```

Edit package.json to the line indicating preview from this:

```json
"preview": "vite preview",
```

to this:

```json
"preview": "vite preview --host 0.0.0.0 --port 8080",
```

Then, issue the following commands from the server, in the directory of the project under development:

```bash
npm run build
npm run preview
```

Then, to check the connectivity, I will need to move to the client and type the following command from the terminal:

```bash
sudo nmap 192.168.122.103 -Pn -p 8080
```

Finally, I can type the following address:

```text
http://192.168.1.XXX:8080
```

on the respective browser bar and get a preview of the micro-frontend web application.
