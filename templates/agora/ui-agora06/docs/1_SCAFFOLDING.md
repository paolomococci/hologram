# scaffolding

First I typed the following commands to install the necessary:

```bash
su -
npm i -g typescript
tsc --help
tsc --version
npm i -g @angular/cli
ng --help
ng --version
exit
```

after which I typed the following:

```bash
cd /var/www/html/agora-project/
ng new --skip-git --skip-install --strict --style=css --minimal --routing --ssr=false --dry-run ui-agora06
ng new --skip-git --skip-install --strict --style=css --minimal --routing --ssr=false ui-agora06
cd ui-agora06/
npm install
```

## installation of `ngx-tailwind`

```bash
ng add ngx-tailwind
```

## installation of the icons `lucide-angular`

```bash
npm i lucide-angular
```

## check the licenses of the packages used

```bash
license-report --output=csv > licenses_report.csv
```

## I add the service `Posts` and the components that will use it

```bash
ng generate service --help
ng generate service Posts --flat
ng generate component --help
ng generate component PostList --flat --standalone
ng generate component PostCard --flat --standalone --inline-template --inline-style
```

## build

```bash
npm run build
```

Now it's time to fix the permissions:

```bash
chown --recursive developer_username:apache .
```

## some tips

### to prevent the final semicolon from being automatically inserted

Edit the `.prettierrc` file as follows:

```conf
{
    "semi": false
}
```

### how to insert arbitrary file into build directory

Just put the file of interest in the `public` directory.
Run the build and verify the inclusion with the following command:

```bash
ls -al /var/www/html/agora-project/ui-agora06/dist/ui-agora06/browser/
```

### how to prevent `Not Found` error when the application is served by a real web server

To prevent 404 error given by the routing mechanism provided by the framework when the application is running on a real web server just insert a properly edited `.htaccess` file into the `public` directory.

For example something like the following `.htaccess` file:

```conf
DirectoryIndex index.html

RewriteEngine On

RewriteRule ^index\.html$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.html [L]
```
