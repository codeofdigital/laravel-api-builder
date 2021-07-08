<?php

return [
    'base_uri' => env('API_BUILDER_BASE_URI'),

    'user' => [
        'guards' => [
            'web', 'api'
        ]
    ],

    'resolver' => [
        'user' => CodeOfDigital\ApiBuilder\Resolvers\UserResolver::class
    ]
];
