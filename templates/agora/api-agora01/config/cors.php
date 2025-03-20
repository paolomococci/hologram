<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => [
        'GET',
        'OPTIONS',
    ],

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

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
