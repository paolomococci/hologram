# LLM setup

Install:

```shell
ssh developer_username@192.168.XXX.XXX
mkdir ollama && cd ollama
curl -fsSL https://ollama.com/install.sh | sh
```

However, it is always better to follow the instructions on the project website.

### functionality check

Simple command line tests:

```shell
ollama --help
ollama list
ollama ps
ollama help pull
ollama help run
```

### choose a model

Pull and run a model:

```shell
ollama run llm_name
```

## configure Ollama server

```shell
su -
systemctl status ollama --no-pager
nano /etc/systemd/system/ollama.service
```

Restart service:

```shell
systemctl daemon-reload
systemctl restart ollama
systemctl status ollama --no-pager
```

## make the service accessible remotely

Optional step, only if you want to make the service accessible remotely:

```shell
nano /etc/systemd/system/ollama.service
```

add the host line after the service entry, as shown below:

```conf
[Service]
Environment="OLLAMA_HOST=0.0.0.0"
```

To then restart the service:

```shell
systemctl daemon-reload
systemctl restart ollama
systemctl status ollama --no-pager
```

Now it's time to open the tcp port `11434`:

```shell
systemctl status firewalld
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=11434 protocol="tcp" accept'
firewall-cmd --reload
```

Finally, for completeness it would be a good idea to test the connectivity of the service:

```shell
nc -vz -w 3 192.168.XXX.XXX 11434
nmap -Pn 192.168.XXX.XXX -p 11434
```

_Of course, `192.168.XXX.XXX` is just a placeholder that must be replaced with the IP address actually in use._

## trick to pass a document from the shell to an `LLM`

Here's a super easy way to have a short document reviewed:

```shell
ollama run llm_name < /full_directory_path/README.md
```

Or, if it doesn't work, you could get help from the `cat` command:

```shell
cat /full_directory_path/README.md | ollama run llm_name
```

---

## If the service won't start.

A non-starting service may be caused by permission problems. The following shell commands offer a potential solution:

```shell
su -
journalctl -u ollama
chown -R ollama:ollama /usr/share/ollama
chmod 755 /usr/share/ollama
nano /etc/systemd/system/ollama.service
```

Setup example:

```conf
[Unit]
Description=Ollama Service
After=network-online.target

[Service]
Environment="OLLAMA_HOST=0.0.0.0"
ExecStart=/usr/local/bin/ollama serve
User=ollama
Group=ollama
Restart=always
RestartSec=3
Environment="PATH=$PATH"

[Install]
WantedBy=multi-user.target
```

Save and restart the service, following these steps:

```shell
systemctl daemon-reload
systemctl restart ollama
```

You should then verify its operation:

```shell
systemctl status ollama
exit
ollama list
```
