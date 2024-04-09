# PostgreSQL setup

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
if [ -d "/usr/lib/postgresql/14/bin" ] ; then
    PATH="/usr/lib/postgresql/14/bin:$PATH"
fi
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
```

The following command is used to obtain a list of databases present in the system:

```console
\l
```

and this to change working database:

```console
\c landing_db
```

Now it's time to log in with the newly created account:

```bash
psql -U developer_username
```

## allow access to the RDBMS from the network

You need to edit the files `pg_hba.conf` and `postgresql.conf`.

```bash
locate pg_hba.conf
sudo nano /etc/postgresql/14/main/pg_hba.conf
```

At the end of file type:

```text
host    all     developer_username   192.168.1.0/24        scram-sha-256
```

```bash
locate postgresql.conf
sudo nano /etc/postgresql/14/main/postgresql.conf
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
sudo netstat -nlp | grep "5432"
```

### check

Here is a command to try on the client workstation with root credentials:

```bash
nmap -Pn 192.168.1.123 -p 5432
```
