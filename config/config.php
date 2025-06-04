<?php

return [
    'enabled' => env('LARAVEL_LENS_ENABLED', false),
    'default' => env('LARAVEL_LENS_DRIVER', 'simple'),
    'route-prefix' => env('LARAVEL_LENS_ROUTE_PREFIX', 'laravel-lens'),
    'username' => env('LARAVEL_LENS_USERNAME', 'laravel-lens'),
    'password' => env('LARAVEL_LENS_PASSWORD', 'laravel-lens'),
    'session_name' => env('LARAVEL_LENS_SESSION_NAME', 'laravel-lens-session'),
    'drivers' => [
        'simple' => [
            'driver' => 'simple'
            ]
        ],
        'background_logs_table' => [
            'table' => 'background_task_infos',
            'last_run_column' => 'last_run',
            'last_run_finished_column' => 'last_run_finished',
            'task_name_column' => 'task_name'
        ]
];
