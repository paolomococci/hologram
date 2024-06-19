# database setup of MariaDB

```bash
cd /etc/mysql/
grep -ri "bind-address" .
sudo nano ./mariadb.conf.d/50-server.cnf
```

Now you need to replace the following line:

```text
bind-address            = 127.0.0.1
```

with this other one:

```text
bind-address            = 0.0.0.0
```

But it is better to modify with sed and then check the result:

```bash
grep -i "bind-address" /etc/mysql/mariadb.conf.d/50-server.cnf
sudo sed -i 's/bind-address            = 127.0.0.1/bind-address            = 0.0.0.0/g' /etc/mysql/mariadb.conf.d/50-server.cnf
```

then I can do a quick check:

```bash
grep -i "bind-address" /etc/mysql/mariadb.conf.d/50-server.cnf
```

## finally setup of MariaDB

```bash
sudo mariadb -u root
```

### into MariaDB cli

```sql
SHOW DATABASES;
SELECT `user`, `host` FROM `mysql`.`user`;
ALTER USER 'root'@'localhost' IDENTIFIED BY 'database_admin_password';
FLUSH PRIVILEGES;
SELECT PASSWORD('database_developer_password');
```

This last command returns a hash to use later:

```sql
CREATE USER IF NOT EXISTS 'developer_username'@'localhost' IDENTIFIED BY PASSWORD 'database_developer_password_hash';
CREATE DATABASE IF NOT EXISTS `landing_db`;
GRANT ALL ON *.* TO 'developer_username'@'localhost';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```

and a specific host as you wish:

```sql
CREATE USER IF NOT EXISTS 'developer_username'@'192.168.1.1' IDENTIFIED BY PASSWORD 'database_developer_password_hash';
GRANT ALL ON *.* TO 'developer_username'@'192.168.1.1';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```

## complete setup

```bash
sudo mysql_secure_installation
```

## restart database service

```bash
sudo systemctl restart mariadb
sudo systemctl status mariadb -l --no-pager
```
