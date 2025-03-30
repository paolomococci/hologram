# setup of `CORS`

```bash
php artisan config:publish cors
```

## example of setup of `config/cors.php`

```php
<?php

return [

'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => [
        'GET',
        'OPTIONS',
    ],

    // Access-Control-Allow-Origin
    'allowed_origins' => [
        'https://ui-agora01.hologram-srv.local',
        'https://ui-agora02.hologram-srv.local',
        'https://ui-agora03.hologram-srv.local',
        'https://ui-agora04.hologram-srv.local',
        'https://ui-agora05.hologram-srv.local',
        'https://ui-agora07.hologram-srv.local',
        'https://ui-agora08.hologram-srv.local',
    ],

    'allowed_origins_patterns' => [],

    // Access-Control-Allow-Headers
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Access-Control-Allow-Credentials
    'supports_credentials' => true,

];
```

Please note that the web application consuming the API may encounter an error that the self-signed certificate is not valid when requesting `csrf-cookie`.
This inconvenience that occurs during development is easily overcome by pointing the browser to the base address of the API service and accepting the aforementioned certificate.
