<?php

return [
    /*
     |---------------------------------------------------------------
     | API Base Uri
     |---------------------------------------------------------------
     |
     | Define the base URI for the API request call.
     |
     */
    'base_uri' => env('API_BUILDER_BASE_URI'),

    /*
     |---------------------------------------------------------------
     | API Token
     |---------------------------------------------------------------
     |
     | Define the API token for the base URL that you are going to call.
     |
     */
    'token' => env('API_BUILDER_TOKEN'),

    /*
     |---------------------------------------------------------------
     | API User Guards & Morph Prefix
     |---------------------------------------------------------------
     |
     | Define the morph prefix and authentication guard for the User resolver.
     |
     */
    'user' => [
        'morph_prefix' => 'user',
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
        'user_agent' => CodeOfDigital\ApiBuilder\Resolvers\UserAgentResolver::class
    ],

    /*
     |---------------------------------------------------------------
     | API Logging
     |---------------------------------------------------------------
     |
     | Determine whether API logging is enabled or disabled
     | Set to true if you want to log API requests and responses
     |
     */
    'logging' => true,

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
