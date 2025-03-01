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
ng new --skip-git --skip-install --strict --style=css --minimal --routing --ssr=false --dry-run ui-agora03
ng new --skip-git --skip-install --strict --style=css --minimal --routing --ssr=false ui-agora03
cd ui-agora03/
npm install
ng add ngx-tailwind
```

## install the icons `lucide-angular`

```bash
npm i lucide-angular
```

## check the licenses of the packages used

```bash
license-report --output=csv > licenses_report.csv
```

## build

```bash
npm run build
```

Now it's time to fix the permissions:

```bash
chown --recursive developer_username:apache .
```
