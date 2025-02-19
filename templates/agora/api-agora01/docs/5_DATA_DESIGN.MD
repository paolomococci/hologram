# data structure design

Database design.

## thesis data tables

### model `Posts`

First I set the model:

```bash
php artisan make:model Posts --all --api --pest
```

### model `Refusal`

First I set the model:

```bash
php artisan make:model Refusal --all --api --pest
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
