<?php

namespace CodeOfDigital\ApiBuilder\Contracts;

interface IpAddressResolver
{
    /**
     * Resolve the IP Address.
     *
     * @return string
     */
    public static function resolve(): string;
}
