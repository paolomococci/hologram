# reusable components

## components without controller

```bash
php artisan make:component Elements/Samp/ShowErrors --view
php artisan make:component Elements/Label/InputLabel --view
php artisan make:component Elements/Input/InputRequired --view
php artisan make:component Elements/Input/InputOptional --view
php artisan make:component Elements/Input/Name --view
php artisan make:component Elements/Input/Email --view
php artisan make:component Elements/Input/Password --view
php artisan make:component Elements/Textarea/TextareaRequired --view
php artisan make:component Elements/Textarea/TextareaOptional --view
php artisan make:component Elements/Button/TextButton --view
```

## component used for development the other components

```bash
php artisan make:component Elements/Scaffold/Scaffold --view
```
