<?php

namespace CodeOfDigital\ApiBuilder\Tests;

use CodeOfDigital\ApiBuilder\ApiBuilderServiceProvider;
use CodeOfDigital\ApiBuilder\Resolvers\IpAddressResolver;
use CodeOfDigital\ApiBuilder\Resolvers\UserAgentResolver;
use CodeOfDigital\ApiBuilder\Resolvers\UserResolver;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        // Database
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);

        // API Builder
        $app['config']->set('api-builder.base_uri', 'https://jsonplaceholder.typicode.com');
        $app['config']->set('api-builder.token', 'foobar');
        $app['config']->set('api-builder.drivers.database.connection', 'testdb');
        $app['config']->set('api-builder.user.morph_prefix', 'user');
        $app['config']->set('api-builder.user.guards', [
            'web',
            'api',
        ]);
        $app['config']->set('api-builder.resolver.user', UserResolver::class);
        $app['config']->set('api-builder.resolver.ip_address', IpAddressResolver::class);
        $app['config']->set('api-builder.resolver.user_agent', UserAgentResolver::class);
        $app['config']->set('api-builder.logging', true);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->withFactories(__DIR__.'/database/factories');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ApiBuilderServiceProvider::class];
    }
}