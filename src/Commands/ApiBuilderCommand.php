<?php

namespace CodeOfDigital\ApiBuilder\Commands;

use Illuminate\Console\GeneratorCommand;

class ApiBuilderCommand extends GeneratorCommand
{
    public $signature = 'make:api-builder {name}';

    public $description = 'Create a new API request builder class';

    protected $type = 'API Builder Class';

    protected function getStub()
    {
        return __DIR__ . '/stubs/api-builder.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\ApiBuilder\Builder';
    }
}
