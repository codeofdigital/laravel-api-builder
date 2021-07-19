<?php

return [
    'base_uri' => env('API_BUILDER_BASE_URI'),

    'token' => env('API_BUILDER_TOKEN'),

    /*
     |---------------------------------------------------------------
     | API User Guards
     |---------------------------------------------------------------
     |
     | Define the authentication guard for the User resolver.
     |
     */
    'user' => [
        'guards' => [
            'web', 'api'
        ]
    ],

    /*
     |---------------------------------------------------------------
     | API Builder Model
     |---------------------------------------------------------------
     |
     | Define which ApiLog model is implemented and used during logging.
     |
     */

    'model' => CodeOfDigital\ApiBuilder\Models\ApiLog::class,

    /*
     |---------------------------------------------------------------
     | API Builder Resolver
     |---------------------------------------------------------------
     |
     | Define the User, IP Address, User Agent, HTTP Method, Domain
     | and Path resolver implementations.
     |
     */
    'resolver' => [
        'user' => CodeOfDigital\ApiBuilder\Resolvers\UserResolver::class,
        'ip_address' => CodeOfDigital\ApiBuilder\Resolvers\IpAddressResolver::class,
        'user_agent' => CodeOfDigital\ApiBuilder\Resolvers\UserAgentResolver::class,
        'method' => CodeOfDigital\ApiBuilder\Resolvers\MethodResolver::class,
        'domain' => CodeOfDigital\ApiBuilder\Resolvers\DomainResolver::class,
        'path' => CodeOfDigital\ApiBuilder\Resolvers\PathResolver::class
    ],

    /*
     |---------------------------------------------------------------
     | API Builder Database Configurations
     |---------------------------------------------------------------
     |
     | Configure the database connection and table for API logging.
     |
     */
    'drivers' => [
        'database' => [
            'connection' => null,
            'table' => 'api_logs'
        ]
    ]
];
