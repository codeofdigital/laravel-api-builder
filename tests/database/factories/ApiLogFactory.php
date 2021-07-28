<?php

use Faker\Generator as Faker;
use CodeOfDigital\ApiBuilder\Tests\Models\ApiLog;
use CodeOfDigital\ApiBuilder\Tests\Models\User;

/*
|--------------------------------------------------------------------------
| ApiLog Factories
|--------------------------------------------------------------------------
*/

$factory->define(ApiLog::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'user_type' => User::class,
        'method' => 'GET',
        'domain' => $faker->domainName,
        'path' => null,
        'request_header' => [],
        'request' => [],
        'response_header' => [],
        'response' => [],
        'ip_address' => $faker->ipv4,
        'user_agent' => $faker->userAgent
    ];
});