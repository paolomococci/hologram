# Livewire

An example of how to create a graphical interface to access entities using Blade-Livewire coupling.

## article data access

```bash
php artisan make:livewire article.overview-articles
php artisan make:livewire article.create-article
php artisan make:livewire article.read-article
php artisan make:livewire article.update-article
php artisan make:livewire article.deprecate-article
php artisan make:livewire article.delete-article
```

## author data access

```bash
php artisan make:livewire author.overview-authors
php artisan make:livewire author.create-author
php artisan make:livewire author.read-author
php artisan make:livewire author.update-author
php artisan make:livewire author.deprecate-author
php artisan make:livewire author.delete-author
```

With these commands each time you get two types of files, that is, a Controller and a Blade file.
At this point it is advisable to carefully consult the documentation to fully understand the existing conventions that allow the components to communicate data between themselves and between themselves and the parent.
