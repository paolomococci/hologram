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
        'https://chirps-hologram-srv.local/api/*',
        'https://chirps-hologram-srv.local/sanctum/csrf-cookie'
    ],

    'allowed_methods' => [
        '*',
    ],

    'allowed_origins' => [
        'https://chirps-hologram-srv.local',
        'https://www.posts-cheddar-hologram-srv.local',
        'https://www.posts-tofu-hologram-srv.local',
    ],

    'allowed_origins_patterns' => ['*-hologram-srv.local'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
