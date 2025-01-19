# update the routes

## I have to remember to issue the following commands when I add a new route and it is not listed:

```bash
npm run build
chown --recursive developer_username:apache .
chmod --recursive 775 bootstrap/cache && chmod --recursive 775 storage && chmod --recursive 775 database
php artisan route:cache && php artisan route:clear
```

and, if I am examining the presence of a specific route, the following command has been useful to me:

```bash
php artisan route:list | grep "help"
```
