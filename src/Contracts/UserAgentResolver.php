<?php

namespace CodeOfDigital\ApiBuilder\Contracts;

interface UserAgentResolver
{
    /**
     * Resolve the User Agent.
     *
     * @return string|null
     */
    public static function resolve();
}
