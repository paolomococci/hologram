# LLM setup

## increase memory ram of virtual machine from `4GB` to `8GB`

On system host the virtual machines:

```bash
su -
virsh
dominfo hologram-llm
setmaxmem hologram-llm 8G --config
setmem hologram-llm 8G --config
start hologram-llm
dominfo hologram-llm
domifaddr hologram-llm
```

Install:

```bash
ssh developer_username@192.168.1.XXX
curl -fsSL https://ollama.com/install.sh | sh
```

However, it is always better to follow the instructions on the project website.

### functionality check

Simple command line tests:

```bash
ollama --help
ollama list
ollama ps
ollama help pull
ollama help run
```

### choose a model

Pull and run a model:

```bash
ollama run llama3.2
```

## configure Ollama server

```bash
su -
systemctl status ollama --no-pager
nano /etc/systemd/system/ollama.service
```

Edit:

```conf
[Service]
Environment="OLLAMA_HOST=0.0.0.0"
```

Restart service:

```bash
systemctl daemon-reload
systemctl restart ollama
systemctl status ollama --no-pager
```

### open port `11434`

```bash
systemctl status firewalld
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=11434 protocol="tcp" accept'
firewall-cmd --reload
```
