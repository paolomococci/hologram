# RDBMS

## setup of MariaDB

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

## setup of PostgreSQL

Start by typing the following command:

```bash
postgres --version
```

If the command is not found but you are sure that you have installed the database server correctly, first you need to find the location of the binary files:

```bash
sudo updatedb
locate postgres | grep "/bin"
```

and then edit the `.profile` file as follows:

```bash
nano .profile
```

Add something like the following to the end of the file, based on the path you just found.

```text
# set postgres bin directory
if [ -d "/usr/lib/postgresql/16/bin" ] ; then
    PATH="/usr/lib/postgresql/16/bin:$PATH"
fi
```

Now I have to load the new settings without logging in again:

```bash
. ~/.profile
```

## add new user

```bash
sudo -u postgres psql
```

In the `psql` console:

```sql
CREATE USER developer_username WITH CREATEDB LOGIN PASSWORD 'password';
```

The following command is used to obtain information about RDBMS users:

```console
\du+
```

to then create the databases for the developer user:

```sql
CREATE DATABASE developer_username WITH OWNER developer_username;
CREATE DATABASE landing_db WITH OWNER developer_username;
CREATE DATABASE private_db WITH OWNER developer_username;
\q
```

Now it's time to log in with the newly created account:

```bash
sudo -u developer_username psql
```

```sql
\c landing_db
CREATE SCHEMA landing_dbs AUTHORIZATION CURRENT_USER;
```

The following command is used to obtain a list of databases present in the system:

```console
\l
```

The following command is used to obtain a list of schemes present in the system:

```console
\dn+
```

this to change working database:

```console
\c landing_db
```

The following command is useful for getting help on how to use the console:

```console
\?
```

and the following command is used to return to the shell:

```console
\q
```

## allow access to the RDBMS from the network

You need to edit the files `pg_hba.conf` and `postgresql.conf`.

```bash
locate pg_hba.conf
sudo nano /etc/postgresql/16/main/pg_hba.conf
```

At the end of file type:

```text
host    all     developer_username   192.168.1.0/24        scram-sha-256
```

```bash
locate postgresql.conf
sudo nano /etc/postgresql/16/main/postgresql.conf
```

```text
listen_addresses = '*'
```

After that, you need to restart the service:

```bash
sudo systemctl restart postgresql
sudo systemctl status postgresql
```

and check its work:

```bash
sudo netstat -nlp | grep "5432"
```

you should get feedback similar to the following:

```text
tcp        0      0 0.0.0.0:5432            0.0.0.0:*               LISTEN      1449/postgres       
tcp6       0      0 :::5432                 :::*                    LISTEN      1449/postgres       
unix  2      [ ACC ]     STREAM     LISTENING     27246    1449/postgres        /var/run/postgresql/.s.PGSQL.5432
```

It's time to open the door to the rest of the internal network:

```bash
sudo ufw allow from 192.168.1.0/24 proto tcp to any port 5432
sudo ufw reload
sudo ufw status numbered
netstat -tln
```

### check

Here is a command to try on the client workstation with root credentials:

```bash
nmap -Pn 192.168.1.XXX -p 5432
```
