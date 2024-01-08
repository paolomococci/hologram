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
CREATE USER IF NOT EXISTS 'paolo'@'localhost' IDENTIFIED BY PASSWORD 'database_developer_password_hash';
CREATE DATABASE IF NOT EXISTS `landing_db`;
GRANT ALL ON `landing_db`.* TO 'paolo'@'localhost';
FLUSH PRIVILEGES;
CREATE USER IF NOT EXISTS 'paolo'@'%' IDENTIFIED BY PASSWORD 'database_developer_password_hash';
GRANT ALL ON `landing_db`.* TO 'paolo'@'%';
FLUSH PRIVILEGES;
SELECT `user`, `host` FROM `mysql`.`user`;
quit
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
