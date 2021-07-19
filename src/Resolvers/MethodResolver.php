<?php

namespace CodeOfDigital\ApiBuilder\Resolvers;

use Illuminate\Support\Facades\Request;

class MethodResolver implements \CodeOfDigital\ApiBuilder\Contracts\MethodResolver
{
    /**
     * @inheritDoc
     */
    public static function resolve(): string
    {
        return Request::method();
    }
}
