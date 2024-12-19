# development

## model `Article`

```bash
cd /var/www/html/remark/
php artisan make:model --all Article
php artisan livewire:form ArticleForm

```

## components of `article`

```bash
php artisan make:livewire Article/article-index
php artisan make:livewire Article/article-create
php artisan make:livewire Article/article-read
php artisan make:livewire Article/article-update
php artisan make:livewire Article/article-delete
```

An example of an inline component:

```bash
php artisan make:livewire Article/article-search --inline
php artisan make:livewire Article/article-list --inline
php artisan make:livewire Article/article-stats --inline
```

## fix coding style

```bash
./vendor/bin/pint
```

### data model definition, factories, seeders and migration

```bash
php artisan migrate:status
php artisan migrate --pretend
php artisan migrate
php artisan migrate:status
php artisan model:show Article
php artisan db:seed
php artisan db:show
php artisan db:show --counts
php artisan db:table -- articles
php artisan db:table -- teams
php artisan db:table -- users
```

Check:

```bash
php artisan tinker
```

and now:

```sh
App\Models\Article::all()
App\Models\Team::all()
App\Models\User::all()
quit
```

### only if necessary

```bash
npm run build
```

### only if necessary

```bash
chmod --recursive 775 storage
chown --recursive --verbose 0:33 .
```
