# database setup

I create the database and its administrator user:

Create a user `admin` and `gutter_db` database:

User `admin` on `localhost`

```sql
SHOW DATABASES;
SELECT PASSWORD('any_password');
CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY PASSWORD 'any_hashed_password';
CREATE DATABASE IF NOT EXISTS `gutter_db`;
GRANT ALL ON `gutter_db`.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
SELECT `user`, `password`, `host`, `Super_priv` FROM `mysql`.`user`;
```

User `admin` on `192.168.1.1`

```sql
CREATE USER IF NOT EXISTS 'admin'@'192.168.1.1' IDENTIFIED BY PASSWORD 'any_hashed_password';
GRANT ALL ON `gutter_db`.* TO 'admin'@'192.168.1.1';
FLUSH PRIVILEGES;
SELECT `user`, `password`, `host`, `Super_priv` FROM `mysql`.`user`;
```
