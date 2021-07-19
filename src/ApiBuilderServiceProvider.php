<?php

namespace CodeOfDigital\ApiBuilder;

use CodeOfDigital\ApiBuilder\Commands\ApiBuilderCommand;
use Illuminate\Support\ServiceProvider;

class ApiBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishAssets();
        $this->mergeConfigFrom(__DIR__.'/../config/api-builder.php', 'api-builder');
    }

    protected function publishAssets()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config/api-builder.php' => base_path('config/api-builder.php')]);
            $this->publishes([__DIR__.'/../database/migrations/api_logs.stub' => database_path(
                sprintf('migrations/%s_create_api_logs_table.php', date('Y_m_d_His'))
            )]);
        }
    }

    public function register()
    {
        if ($this->app->runningInConsole())
            $this->commands([ApiBuilderCommand::class]);
    }
}
