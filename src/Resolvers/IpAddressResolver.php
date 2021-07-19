<?php

namespace CodeOfDigital\ApiBuilder\Resolvers;

use Illuminate\Support\Facades\Request;

class IpAddressResolver implements \CodeOfDigital\ApiBuilder\Contracts\IpAddressResolver
{
    /**
     * @inheritDoc
     */
    public static function resolve(): string
    {
        return Request::ip();
    }
}
