# `agora-be-cntr-1-0` agora

## credentials

*root system password of backend:*  some_password

## access the container with root credentials

```bash
podman exec --interactive --tty --privileged agora-be-cntr-1-0 bash
```

## check if i need to update the system

If necessary upgrade the development environment and tools:

```bash
apt update && apt upgrade -y
composer --version
composer self-update
npm -v
npm view npm version
node -v
npm view node version
npm cache clean -f && npm install -g n && n stable && npm install -g npm@latest
```

## application scaffolding

```bash
sed -i "s/landing/agora/g" /etc/apache2/sites-available/default-ssl.conf
cat /etc/apache2/sites-available/default-ssl.conf | grep agora
sed -i "s/landing/agora/g" /etc/apache2/sites-available/000-default.conf
cat /etc/apache2/sites-available/000-default.conf | grep agora
apachectl --help
apachectl restart
composer list
ls -l
composer create-project laravel/laravel agora
cat /etc/passwd | grep 'root'
cat /etc/passwd | grep 'www-data'
chown --recursive --verbose 0:33 agora/
cd agora
composer suggest --all
php artisan migrate:status
ls -l
stat -c %a bootstrap/cache
find bootstrap/cache -printf '%m %p \n'
find storage -printf '%m %p \n'
find database -printf '%m %p \n'
chmod --recursive 775 bootstrap/cache
chmod --recursive 775 storage
chmod --recursive 775 database
php artisan cache:clear
```

## setup of Jetstream

Considering I'm in the root directory of the project:

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --teams --dark
npm install
npm run build
php artisan migrate:status
chown --recursive --verbose 0:33 .
php artisan cache:clear
```

## commands that may prove useful

To diagnose any problems:

```bash
composer --help diagnose
composer diagnose
```

## stop and start the system

```bash
exit
podman stop agora-be-cntr-1-0
podman start agora-be-cntr-1-0
podman exec --interactive --tty --privileged agora-be-cntr-1-0 bash
```
