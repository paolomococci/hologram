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

Otherwise it will not be possible to connect with a SQL IDE.

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
GRANT ALL ON `landing_db`.* TO 'developer_username'@'localhost';
FLUSH PRIVILEGES;
CREATE USER IF NOT EXISTS 'developer_username'@'%' IDENTIFIED BY PASSWORD 'database_developer_password_hash';
GRANT ALL ON `landing_db`.* TO 'developer_username'@'%';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```

If the developer user needs permissions to create databases remotely it will be necessary to issue the following commands:

```sql
GRANT ALL ON *.* TO 'developer_username'@'%';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```

If you believe that the previous type of access is too extensive, you can restrict it to a subnet:

```sql
CREATE USER IF NOT EXISTS 'developer_username'@'192.168.1.0/24' IDENTIFIED BY PASSWORD 'database_developer_password_hash';
GRANT ALL ON *.* TO 'developer_username'@'192.168.1.0/24';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```

or a specific host as you wish:

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
