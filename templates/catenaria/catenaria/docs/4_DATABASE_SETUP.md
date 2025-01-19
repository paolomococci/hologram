# database setup

Create a new database `catenaria_db` with collection type `utf8_unicode_ci`.

## reset the entire database

Edit `.env`:

```env
# DB_CONNECTION=sqlite

# catenaria_db
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=catenaria_db
DB_USERNAME=developer_username
DB_PASSWORD=developer_password
```
