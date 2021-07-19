<?php

namespace CodeOfDigital\ApiBuilder\Contracts;

interface DomainResolver
{
    /**
     * Resolve the URL Domain.
     *
     * @return string
     */
    public static function resolve(): string;
}
