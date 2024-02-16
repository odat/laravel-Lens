<?php

return [
    'default' => env('LARAVEL_LENS_DRIVER', 'simple'),
    'route-prefix' => env('LARAVEL_LENS_ROUTE_PREFIX', 'laravel-lens'),
    'username' => env('LARAVEL_LENS_USERNAME', 'laravel-lens'),
    'password' => env('LARAVEL_LENS_PASSWORD', 'laravel-lens'),
    'session_name' => env('LARAVEL_LENS_SESSION_NAME', 'laravel-lens-session'),
    'drivers' => [
        'simple' => [
            'driver' => 'simple'
        ]
    ]
];
