<?php

namespace CodeOfDigital\ApiBuilder\Resolvers;


use Illuminate\Support\Facades\Request;

class DomainResolver implements \CodeOfDigital\ApiBuilder\Contracts\DomainResolver
{
    /**
     * @inheritDoc
     */
    public static function resolve(): string
    {
        return Request::url();
    }
}
