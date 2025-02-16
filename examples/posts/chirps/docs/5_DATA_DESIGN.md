# data structure design

Database design.

## thesis data tables

### model `Posts`

```bash
php artisan make:model Posts --all --api --pest
php artisan make:controller Rest/PostsRestController
```

### model `Refusal`

```bash
php artisan make:model Refusal --all --api --pest
php artisan make:controller Rest/RefusalRestController
```

### data model definition, factories, seeders and migration

```bash
php artisan migrate:status
php artisan migrate --pretend
php artisan migrate
php artisan migrate:status
php artisan model:show Posts
php artisan model:show Refusal
php artisan model:show User
php artisan db:show
php artisan db:show --counts
php artisan db:table -- posts
php artisan db:table -- refusals
php artisan db:table -- users
```

Check:

```bash
php artisan tinker
```

and now:

```sh
App\Models\Posts::all()
App\Models\Refusal::all()
App\Models\User::all()
quit
```

## rollback

```bash
php artisan migrate:rollback
```

## seeding

and, if I have already prepared what is needed to generate the test data, I can also send the following command:

```bash
php artisan db:seed
```

or, for a complete reset of the test data:

```bash
php artisan db:wipe && php artisan migrate:fresh && php artisan db:seed
```

## dump of database

```bash
php artisan schema:dump
```
