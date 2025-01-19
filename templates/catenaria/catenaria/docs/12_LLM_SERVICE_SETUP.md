# LLM service setup

## eventually, if you want to integrate a Laravel web application with an LLM service

```bash
composer require echolabsdev/prism
php artisan vendor:publish --tag=prism-config
./vendor/bin/composer-license-checker report
```

and edit `config/prism.php` like this:

```php
<?php

return [
    'prism_server' => [
        // The middleware that will be applied to the Prism Server routes.
        'middleware' => [],
        'enabled' => env('PRISM_SERVER_ENABLED', true),
    ],
    'providers' => [
        'ollama' => [
            'url' => env('OLLAMA_URL', 'http://localhost:11434/v1'),
        ],
    ],
];
```
