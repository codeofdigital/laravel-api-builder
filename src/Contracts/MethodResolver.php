<?php

namespace CodeOfDigital\ApiBuilder\Contracts;

interface MethodResolver
{
    /**
     * Resolve the HTTP Method.
     *
     * @return string
     */
    public static function resolve(): string;
}
