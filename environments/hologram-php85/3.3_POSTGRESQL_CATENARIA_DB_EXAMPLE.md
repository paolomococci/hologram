# PostgreSQL examples

I connect to the server database from a remote workstation using the terminal:

```shell
psql --host=192.168.1.XXX --port=5432 --username=developer_username
```

I create a new database:

```sql
CREATE DATABASE catenaria_db WITH OWNER developer_username;
```

To select the newly created database:

```sql
\c catenaria_db
```

To view some statistics of the newly created database:

```sql
SELECT * FROM pg_stat_activity WHERE datname = 'catenaria_db';
```

Now I'm moving to another database:

```sql
\c developer_username_db 
```

I change the name of the newly created database:

```sql
ALTER DATABASE catenaria_db RENAME TO catenaria_db;
```

I go back to the new database and perform some operations to create and verify it:

```sql
\c catenaria_db
SELECT current_schema();
SHOW search_path;
CREATE SCHEMA IF NOT EXISTS receiving;
SET search_path TO receiving, public;
SELECT current_schema();
SHOW search_path;
CREATE TABLE IF NOT EXISTS operators (operator_id SERIAL PRIMARY KEY, first_name VARCHAR(32) NOT NULL, last_name VARCHAR(32) NOT NULL, email VARCHAR(64) NOT NULL UNIQUE, mobile VARCHAR(32));
SELECT * FROM receiving.operators;
```

I create some schemes and check their existence:

```sql
CREATE SCHEMA IF NOT EXISTS accounting;
CREATE SCHEMA IF NOT EXISTS management;
CREATE SCHEMA IF NOT EXISTS marketing;
CREATE SCHEMA IF NOT EXISTS mixing;
CREATE SCHEMA IF NOT EXISTS production;
CREATE SCHEMA IF NOT EXISTS purchasing;
CREATE SCHEMA IF NOT EXISTS quality;
CREATE SCHEMA IF NOT EXISTS resources;
CREATE SCHEMA IF NOT EXISTS sales;
CREATE SCHEMA IF NOT EXISTS shipping;
SELECT * FROM pg_catalog.pg_namespace ORDER BY nspname;
```

Setting up the accounting scheme:

```sql
CREATE TABLE IF NOT EXISTS accounting.employees (employee_id SERIAL PRIMARY KEY, first_name VARCHAR(32) NOT NULL, last_name VARCHAR(32) NOT NULL, email VARCHAR(64) NOT NULL UNIQUE, mobile VARCHAR(32) DEFAULT NULL);
SELECT * FROM accounting.employees;
```

I set `search_path` to public again and request some information:

```sql
SET search_path TO public;
SHOW search_path;
SELECT * FROM pg_catalog.pg_tables WHERE schemaname != 'pg_catalog' AND schemaname != 'information_schema';
SELECT * FROM information_schema.columns WHERE table_name = 'operators';
```
