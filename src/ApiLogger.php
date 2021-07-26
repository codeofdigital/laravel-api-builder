<?php

namespace CodeOfDigital\ApiBuilder;

use CodeOfDigital\ApiBuilder\Contracts\IpAddressResolver;
use CodeOfDigital\ApiBuilder\Contracts\UserAgentResolver;
use CodeOfDigital\ApiBuilder\Contracts\UserResolver;
use CodeOfDigital\ApiBuilder\Exceptions\ApiBuilderException;
use Illuminate\Support\Facades\Config;

trait ApiLogger
{
    private function canApiLogging(): bool
    {
        $loggingEnabled = Config::get('api-builder.logging', true);

        if (!$loggingEnabled)
            return false;

        return static::$enableLogging;
    }

    private function createLog(object $data)
    {
        $modelClass = Config::get('api-builder.model', \CodeOfDigital\ApiBuilder\Models\ApiLog::class);
        return call_user_func([$modelClass, 'create'], $this->toCreateLogging($data));
    }

    private function updateLog($apiLog, array $data)
    {
        return call_user_func([$apiLog, 'update'], $data);
    }

    private function toCreateLogging(object $request): array
    {
        $morphPrefix = Config::get('api-builder.user.morph_prefix', 'user');

        $user = $this->resolveUser();

        return $this->transformApiLogging([
            $morphPrefix . '_type' => $user ? $user->getMorphClass() : null,
            $morphPrefix . '_id'   => $user ? $user->getAuthIdentifier() : null,
            'method' => $request->method,
            'domain' => $request->domain,
            'path' => $request->path,
            'request_header' => $request->headers,
            'request' => $request->data,
            'ip_address' => $this->resolveIpAddress(),
            'user_agent' => $this->resolveUserAgent()
        ]);
    }

    protected function transformApiLogging(array $data): array
    {
        return $data;
    }

    /**
     * Resolve the User.
     *
     * @return mixed|null
     * @throws ApiBuilderException
     */
    private function resolveUser()
    {
        $userResolver = Config::get('api-builder.resolver.user');

        if (is_subclass_of($userResolver, UserResolver::class))
            return call_user_func([$userResolver, 'resolve']);

        throw new ApiBuilderException('Invalid UserResolver implementation');
    }

    /**
     * Resolve the IP Address.
     *
     * @return string
     * @throws ApiBuilderException
     */
    private function resolveIpAddress(): string
    {
        $ipAddressResolver = Config::get('api-builder.resolver.ip_address');

        if (is_subclass_of($ipAddressResolver, IpAddressResolver::class))
            return call_user_func([$ipAddressResolver, 'resolve']);

        throw new ApiBuilderException('Invalid IpAddressResolver implementation');
    }

    /**
     * Resolve the User Agent.
     *
     * @return string
     * @throws ApiBuilderException
     */
    private function resolveUserAgent(): string
    {
        $userAgentResolver = Config::get('api-builder.resolver.user_agent');

        if (is_subclass_of($userAgentResolver, UserAgentResolver::class))
            return call_user_func([$userAgentResolver, 'resolve']);

        throw new ApiBuilderException('Invalid UserAgentResolver implementation');
    }
}
