# how to test a web application project in a container built for this purpose

## scaffolding

```bash
cd /var/www/html/
mkdir playground && cd playground
```

After copying the application files into the directory provided for this purpose, I will have to issue the following commands:

```bash
composer install
npm install
npm run build
```

I created a new `database.sqlite` file from shell:

```bash
sqlite3 --help
sqlite3 ./database/database.sqlite
```

From the `sqlite3` prompt I send the following commands:

```sh
.databases
.read /var/www/html/playground/database/database.sqlite
.exit
```

to then generate the correct format and content:

```bash
php artisan db:wipe
php artisan migrate:fresh
php artisan migrate:status
php artisan db:seed
```

Now I need to set the correct file owners and permissions, as well as clear the route cache:

```bash
chmod --recursive 775 bootstrap/cache && chmod --recursive 775 storage && chmod --recursive 775 database && chown --recursive --verbose 0:33 .
php artisan route:cache && php artisan route:clear && php artisan route:list
```
