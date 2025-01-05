# data setup

Since this is a cloned virtual machine, the database setup has already been done.

If the developer user needs permissions to create databases remotely it will be necessary to issue the following commands:

```bash
mariadb -u root -p
```

and from sql cli:

```sql
SELECT `user`, `host`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
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

To then revoke the permits which were considerably too extensive:

```sql
REVOKE SUPER ON *.* FROM 'developer_username'@'192.168.1.0/24';
FLUSH PRIVILEGES;
SELECT `user`, `host`, `password`, `Grant_priv`, `Super_priv` FROM `mysql`.`user` ORDER BY `user` DESC;
```
