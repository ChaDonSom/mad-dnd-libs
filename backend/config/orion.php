<?php

return [
    'namespaces' => [
        'models' => 'App\\Models\\',
        'controllers' => 'App\\Http\\Controllers\\Api\\'
    ],

    'auth' => [
        'guard' => 'sanctum'
    ],

    'specs' => [
        'info' => [
            'title' => 'Mad DnD Libs API',
            'description' => 'API documentation for Mad DnD Libs game',
            'version' => env('APP_VERSION', '1.0.0')
        ]
    ],

    'use_validated' => true,

    'search' => [
        'case_sensitive' => false,
    ],
];
