# scaffolding

Commands to get a simple application to get comfortable with testing:

```shell
php -v
mkdir vanilla && cd vanilla
composer init --name="vanilla/app" --description="example of testing application" --type=project --require="php:^8.5" --no-interaction
composer require --dev pestphp/pest phpunit/phpunit
composer dump-autoload
composer test
```
