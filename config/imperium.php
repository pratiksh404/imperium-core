<?php

return [
    'author' => 'Pratik Shrestha',
    'debug' => env('APP_DEBUG', true),

    'name' => env('APP_NAME', 'Imperium'),

    'application' => App\Imperium\Application::class,
    'models' => [
        'user' => \App\Models\User::class,
        'role' => \App\Models\Admin\Role::class,
        'permission' => \App\Models\Admin\Permission::class,
        'position' => \App\Models\Admin\Position::class,
    ],

    'media' => [
        'image' => [
            'logo' => [
                'dark' => 'imperium/assets/img/app/logo-dark.png',
                'light' => 'imperium/assets/img/app/logo-light.png',
                'small' => 'imperium/assets/img/app/logo-sm.png',
            ],
            'favicon' => 'imperium/assets/img/app/favicon.ico',
            'auth' => [
                'background' => 'imperium/assets/img/app/bg.jpg',
            ],
        ],
    ],

    'schema' => [
        'rules' => [
            'default' => [
                'default' => ['nullable'],
            ],
            'tinyint' => [
                'configurations' => [
                    'boolean' => true,
                ],
                'default' => ['boolean'],
            ],
            'smallint' => ['default' => ['numeric']],
            'mediumint' => ['default' => ['numeric']],
            'bigint' => ['default' => ['numeric']],
            'char' => [
                'default' => ['min:0'],
            ],
            'text' => [
                'default' => ['min:0'],
            ],
            'int' => [
                'default' => ['integer'],
            ],
            'unsigned' => [
                'default' => [],
            ],
            'double' => [
                'default' => ['numeric'],
            ],
            'decimal' => [
                'default' => ['numeric'],
            ],
            'dec' => [
                'default' => ['numeric'],
            ],
            'float' => [
                'default' => ['numeric'],
            ],
            'enum' => [
                'default' => ['string'],
            ],
            'set' => [
                'default' => ['string'],
            ],
            'year' => [
                'default' => ['integer', 'min:1901', 'max:2155'],
            ],
            'date' => [
                'default' => ['date'],
            ],
            'time' => [
                'default' => ['date'],
            ],
            'timestamp' => [
                'default' => ['date', 'after_or_equal:1970-01-01 00:00:01', 'before_or_equal:2038-01-19 03:14:07'],
            ],
            'json' => [
                'default' => ['json'],
            ],
        ],
    ],
];
