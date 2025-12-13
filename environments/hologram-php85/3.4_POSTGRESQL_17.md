# installation of PostgreSQL 17

```shell
su -
dnf module list postgresql
```

If you already have a PostgreSQL installation you will need to issue the following commands:

```shell
dnf -qy module disable postgresql
systemctl stop postgresql
dnf remove postgresql-server postgresql-contrib
```

Otherwise:

```shell
wget --spider --https-only https://download.postgresql.org/pub/repos/yum/reporpms/EL-9-x86_64/pgdg-redhat-repo-latest.noarch.rpm
dnf install -y https://download.postgresql.org/pub/repos/yum/reporpms/EL-9-x86_64/pgdg-redhat-repo-latest.noarch.rpm
dnf info postgresql17-server
dnf info postgresql17-contrib
dnf info postgresql-server
dnf info postgresql-contrib
dnf info postgresql-devel
dnf install postgresql17-server postgresql17-contrib postgresql17-devel
dnf list installed | grep postgresql
```

After making sure that only version seventeen is installed, I can perform the setup:

```shell
/usr/pgsql-17/bin/postgresql-17-setup initdb
systemctl enable --now postgresql-17
systemctl status postgresql-17
su postgres
psql
```

```sql
ALTER USER postgres WITH PASSWORD 'secure_password';
```

## allow access to the RDBMS from the network

You need to edit the files `pg_hba.conf` and `postgresql-17.conf`.

```shell
su -
updatedb
locate pg_hba.conf
```

Edit `pg_hba.conf`:

```shell
nano /var/lib/pgsql/17/data/pg_hba.conf
```

At the end of file type:

```text
# TYPE      DATABASE        USER                ADDRESS                 METHOD
host        all         developer_username   192.168.1.0/24             md5
```

```shell
locate postgresql.conf
```

Edit `pg_hba.conf`:

```shell
nano /var/lib/pgsql/17/data/postgresql.conf
```

```text
listen_addresses = '*'
```

After that, you need to restart the service:

```shell
systemctl restart postgresql-17
systemctl status postgresql-17
```

and check its work:

```shell
netstat -nlp | grep "5432"
```

you should get feedback similar to the following:

```text
tcp        0      0 0.0.0.0:5432            0.0.0.0:*               LISTEN      7934/postgres       
tcp6       0      0 :::5432                 :::*                    LISTEN      7934/postgres       
unix  2      [ ACC ]     STREAM     LISTENING     41179    7934/postgres        /tmp/.s.PGSQL.5432
unix  2      [ ACC ]     STREAM     LISTENING     41178    7934/postgres        /run/postgresql/.s.PGSQL.5432
```

It's time to open the door to the rest of the internal network:

```shell
netstat -tln
netstat -nlp | grep "5432"
```

### check

Here is a command to try on the client workstation with root credentials:

```shell
nmap -Pn 192.168.1.XXX -p 5432
```

## connect remotely using the shell

Once you have verified connectivity as described above, you can connect by typing, for example, something similar to the following:

```shell
psql --host=192.168.1.XXX --port=5432 --username=developer_username
```

## backup

```shell
su - postgres
pg_dump -d db -f db_backup.sql
```

## check

```shell
journalctl -u postgresql-17 --no-pager | tail -50
```
