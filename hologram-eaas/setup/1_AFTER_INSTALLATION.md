# system setup

## check

```bash
dnf check-update --refresh
dnf upgrade
dnf search nmap
dnf install nmap
dnf search cockpit
dnf list installed
dnf list available
systemctl status cockpit
systemctl enable --now cockpit.socket
systemctl status cockpit
```

## firewalld

```bash
systemctl status firewalld
firewall-cmd --help
firewall-cmd --list-all
firewall-cmd --get-zones
```

### firewall-cmd how to add rich rules

```bash
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=80 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=3306 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=5173 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8021 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8022 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8080 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8090 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8443 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8444 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=9003 protocol="tcp" accept'
firewall-cmd --reload
```

### firewall-cmd how to remove rich rules

```bash
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=80 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8022 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8080 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=8443 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=9003 protocol="tcp" accept'
firewall-cmd --reload
```
