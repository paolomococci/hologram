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
ng new --skip-git --skip-install --strict --style=css --minimal --routing --ssr=false --dry-run ui-agora03
cd ui-agora03/
npm install
ng add ngx-tailwind
license-report --output=csv > licenses_report.csv
chown --recursive developer_username:apache .
npm run build
```
