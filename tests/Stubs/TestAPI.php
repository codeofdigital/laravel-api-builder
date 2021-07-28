<?php

namespace CodeOfDigital\ApiBuilder\Tests\Stubs;

use CodeOfDigital\ApiBuilder\ApiBuilder;

/**
 * @method static self to(string $method, string $path)
 * @method static self build(...$args)
 *
 * @see ApiBuilder
 */
class TestAPI extends ApiBuilder
{
    protected $authorizationType = null;
}