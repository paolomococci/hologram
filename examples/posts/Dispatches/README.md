# `Dispatches` web API

## after installing `dotnet` and `nginx`

To recap, I first installed the x web server using the following commands:

```bash
su -
dnf list available | grep nginx
dnf info nginx
dnf install nginx
systemctl status nginx
updatedb
locate nginx.conf
rnano /etc/nginx/nginx.conf
```

Then it was the turn of the `dotnet` framework, following the instructions found on the official website, depending on the Linux distribution.

## scaffolding

```bash
dotnet new webapi --use-controllers -o Dispatches
cd Dispatches/
dotnet new gitignore
```

## add `Microsoft.EntityFrameworkCore.InMemory` and `Microsoft.EntityFrameworkCore.Sqlite` packages

```bash
dotnet add package Microsoft.EntityFrameworkCore.InMemory --version 9.0.2
dotnet add package Microsoft.EntityFrameworkCore.Sqlite --version 9.0.2
```

### check licenses

```bash
dotnet tool install --global nuget-license --version 3.1.1
nuget-license -i Dispatches.csproj
```

## commands to configure the firewall so that port 8080 remains open

Here are the commands I need to open port 8080 on my machine:

```bash
su -
firewall-cmd --list-all
firewall-cmd --get-zones
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.XXX.0/24" port port=8080 protocol="tcp" accept'
firewall-cmd --reload
firewall-cmd --list-all
exit
```

Naturally, the IP address given in the example should be appropriately replaced with the one actually in use.

### edit `launchSettings.json`

Then edit the `launchSettings.json` file to look like this:

```json
{
  "$schema": "https://json.schemastore.org/launchsettings.json",
  "profiles": {
    "http": {
      "commandName": "Project",
      "dotnetRunMessages": true,
      "launchBrowser": false,
      "applicationUrl": "http://localhost:5322",
      "environmentVariables": {
        "ASPNETCORE_ENVIRONMENT": "Development"
      }
    },
    "https": {
      "commandName": "Project",
      "dotnetRunMessages": true,
      "launchBrowser": false,
      "applicationUrl": "http://localhost:5322",
      "environmentVariables": {
        "ASPNETCORE_ENVIRONMENT": "Development"
      }
    }
  }
}
```

Of course you will need to set the correct IP address of the server.

## setup Nginx reverse proxy

Edit `/etc/nginx/nginx.conf`:

```conf
...
        # ASP.NET Core web API thanks HTTP protocol
        server {
                listen 8080;
                listen [::]:8080;

                location /api {
                        proxy_pass http://localhost:5322;

                        # Pass the original host and IP address to the backend server
                        proxy_set_header Host $host;
                        proxy_set_header X-Real-IP $remote_addr;
                        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                        proxy_set_header X-Forwarded-Proto $scheme;

                        # Handle connection timeouts and buffering
                        proxy_connect_timeout 60s;
                        proxy_read_timeout 300s;
                        proxy_send_timeout 60s;
                        proxy_buffering on;
                }

                server_name www.hologram-srv.local;
        }
...
```

Starting the proxy server:

```bash
su -
systemctl status nginx
systemctl start nginx
systemctl status nginx
```

And finally I stop the proxy server:

```bash
systemctl stop nginx
exit
```

## consider the SSL development certificate as valid

```bash
dotnet dev-certs https --trust
dotnet run --launch-profile https
```

Or rather, since I want to avoid using HTTPS, it will be necessary to type the following command:

```bash
dotnet run
```

## begin setting up the application deployment

```bash
dotnet --help
dotnet build
```

I start by testing the most important command in the .service file that I will write later:

```bash
/usr/bin/dotnet /var/www/apps/webapi/Dispatches/bin/Debug/net9.0/Dispatches.dll --urls=http://localhost:5322
```

Pay attention to the fact that in this case, the default port will be 5000.

Therefore, the reverse proxy must be configured as follows:

```conf
...
        # ASP.NET Core web API thanks HTTP protocol
        server {
                listen 8080;
                listen [::]:8080;

                location /api {
                        proxy_pass http://localhost:5322;

                        # Pass the original host and IP address to the backend server
                        proxy_set_header Host $host;
                        proxy_set_header X-Real-IP $remote_addr;
                        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                        proxy_set_header X-Forwarded-Proto $scheme;

                        # Handle connection timeouts and buffering
                        proxy_connect_timeout 60s;
                        proxy_read_timeout 300s;
                        proxy_send_timeout 60s;
                        proxy_buffering on;
                }

                server_name www.hologram-srv.local;
        }
...
```

### write the service file (.service) for the web API in question

```bash
su -
nano /usr/lib/systemd/system/kestrel-dispatches.service
```

```conf
[Unit]
Description=This service is responsible for keeping a simple .NET web API deployed on a Linux environment active
After=network.target

[Service]
Type=simple
WorkingDirectory=/var/www/apps/webapi/Dispatches
ExecStart=/usr/bin/dotnet /var/www/apps/webapi/Dispatches/bin/Debug/net9.0/Dispatches.dll
Restart=always
RestartSec=5
KillSignal=SIGINT
SyslogIdentifier=kestrel-dispatches
User=nginx
Environment=ASPNETCORE_URLS=http://localhost:5322/
Environment=ASPNETCORE_ENVIRONMENT=Development
Environment=DOTNET_NOLOGO=true

[Install]
WantedBy=multi-user.target
```

In this case I used the `ASPNETCORE_URLS` environment variable to set not only the host but also the port where the service itself listens.

```bash
systemctl status nginx
systemctl start nginx
systemctl status nginx
ll /usr/lib/systemd/system/ | grep "kestrel-dispatches.service"
systemctl status kestrel-dispatches
systemctl start kestrel-dispatches
systemctl status kestrel-dispatches
systemctl stop kestrel-dispatches
systemctl stop nginx
exit
```
