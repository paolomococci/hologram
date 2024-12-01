# system setup

## check

```bash
dnf repolist
dnf check-update --refresh
dnf install nano wget mlocate
dnf upgrade
dnf search cockpit
dnf list installed | grep cockpit
dnf list available
dnf install cockpit cockpit-storaged cockpit-files
systemctl status cockpit
systemctl enable --now cockpit.socket
systemctl start cockpit
systemctl status cockpit
dnf install yum-utils
dnf config-manager --set-enabled crb
dnf repolist
```

Add an existing user to administrators group:

```bash
usermod --append --groups wheel developer_username
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
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=443 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=3306 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=5173 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --add-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=9003 protocol="tcp" accept'
firewall-cmd --reload
```

### firewall-cmd how to remove rich rules

```bash
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=80 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=443 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=3306 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=5173 protocol="tcp" accept'
firewall-cmd --permanent --zone=public --remove-rich-rule 'rule family="ipv4" source address="192.168.1.0/24" port port=9003 protocol="tcp" accept'
firewall-cmd --reload
```
