# backend

## inside the app container

```shell
podman exec -it --privileged lamp-feather-app bash
cd /var/www/html/feather/
```

## `artisan` command examples

After positioning myself in the root of the project I can issue the following commands:

```shell
php artisan make:model --help
php artisan make:model Task --migration --factory --seed
```

Now I will have to edit the files `app/Models/Task.php`, `database/migrations/2025_11_24_034102_create_tasks_table.php`, `database/factories/TaskFactory.php` e `database/seeders/TaskSeeder.php`.

### migration

```shell
php artisan migrate:status
php artisan migrate --pretend
php artisan migrate
php artisan migrate:status
```

### rollback the last database migration

```shell
php artisan migrate:rollback --pretend
php artisan migrate:rollback
```

### rollback all database migrations

```shell
php artisan migrate:reset --pretend
php artisan migrate:reset
```

### drop all tables and re-run all migrations

```shell
php artisan migrate:fresh --help
php artisan migrate:fresh
```

### seed the database with fake records

```shell
php artisan db:seed --help
php artisan db:seed --class=TaskSeeder
```

### drop all tables, views, and types

```shell
php artisan db:wipe --help
```

### display information about the given database:

```shell
php artisan db:show --help
php artisan db:show --database=sqlite
```

### display information about the given database table:

```shell
php artisan db:table --help
php artisan db:table tasks --database=sqlite
``

`Using `tinker` I could perform a query like this:

```shell
echo json_encode(array_map(fn($r)=>(array)$r, DB::select('SELECT * FROM tasks')), JSON_PRETTY_PRINT);
```

getting a response in JSON format.
