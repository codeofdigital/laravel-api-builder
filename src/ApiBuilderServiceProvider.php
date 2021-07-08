<?php

use Illuminate\Support\ServiceProvider;

class ApiBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/api-builder.php', 'api-builder');
    }

    protected function publishAssets()
    {
        if (!$this->app->runningInConsole() || Str::contains($this->app->version(), 'lumen'))
            return;

        $this->publishes([__DIR__.'/../config/api-builder.php' => config_path('api-builder.php')]);
    }

    public function register()
    {

    }
}
