<?php

namespace CodeOfDigital\ApiBuilder\Resolvers;

use Illuminate\Support\Facades\Request;

class PathResolver implements \CodeOfDigital\ApiBuilder\Contracts\PathResolver
{
    /**
     * @inheritDoc
     */
    public static function resolve(): string
    {
        return Request::path();
    }
}
