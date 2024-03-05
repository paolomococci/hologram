# template engine setup

An example of how to create a graphical interface to access entities using Blade-Livewire coupling.

## article data access

```bash
php artisan make:livewire article.overview-articles
php artisan make:livewire article.create-article
php artisan make:livewire article.read-article
php artisan make:livewire article.update-article
```

## author data access

```bash
php artisan make:livewire author.overview-authors
php artisan make:livewire author.create-author
php artisan make:livewire author.read-author
php artisan make:livewire author.update-author
```

With these commands each time you get two types of files, that is, a Controller and a Blade file.
At this point it is advisable to carefully consult the documentation to fully understand the existing conventions that allow the components to communicate data between themselves and between themselves and the parent.

## list of Blade files which, in my opinion, need to be modified

1. `quotes/resources/views/welcome.blade.php`
2. `quotes/resources/views/navigation-menu.blade.php`
3. `quotes/resources/views/layouts/app.blade.php`
4. `quotes/resources/views/layouts/guest.blade.php`
5. `quotes/resources/views/components/authentication-card-logo.blade.php`
6. `quotes/resources/views/components/welcome.blade.php`
7. `quotes/resources/views/components/application-mark.blade.php`

## list of Blade components to create

1. `quotes/resources/views/article.blade.php`
2. `quotes/resources/views/author.blade.php`
3. `quotes/resources/views/components/article-overview.blade.php`
4. `quotes/resources/views/components/author-overview.blade.php`

## UI tools to maintain data consistency

```bash
php artisan make:livewire contributor.renumber-contrib
php artisan make:livewire contributor.clear-data
```

## set file owners

```bash
chown --recursive --verbose developer_username:www-data .
```
