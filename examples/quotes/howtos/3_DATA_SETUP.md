# data setup

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

Brief introduction, I will create two databases.
The first one, laravel_db, will be used by framework Laravel to operate; the second, quotes_db, will be the database of the actual web application.

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
CREATE DATABASE IF NOT EXISTS `laravel_db`;
CREATE DATABASE IF NOT EXISTS `quotes_db`;
GRANT ALL ON `laravel_db`.* TO 'developer_username'@'localhost';
GRANT ALL ON `quotes_db`.* TO 'developer_username'@'localhost';
FLUSH PRIVILEGES;
CREATE USER IF NOT EXISTS 'developer_username'@'%' IDENTIFIED BY PASSWORD 'database_developer_password_hash';
GRANT ALL ON `laravel_db`.* TO 'developer_username'@'%';
GRANT ALL ON `quotes_db`.* TO 'developer_username'@'%';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```

If the developer user needs permissions to create databases remotely it will be necessary to issue the following commands:

```sql
GRANT ALL ON *.* TO 'developer_username'@'%';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```

To then revoke the permits which were considerably too extensive:

```sql
REVOKE SUPER ON *.* FROM 'developer_username'@'%';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `password`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
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
