<?php

namespace CodeOfDigital\ApiBuilder\Resolvers;

use Illuminate\Support\Facades\Request;

class UserAgentResolver implements \CodeOfDigital\ApiBuilder\Contracts\UserAgentResolver
{
    /**
     * @inheritDoc
     */
    public static function resolve()
    {
        return Request::header('User-Agent');
    }
}
