<?php

namespace CodeOfDigital\ApiBuilder\Contracts;

interface PathResolver
{
    /**
     * Resolve the URL Path.
     *
     * @return string
     */
    public static function resolve(): string;
}
