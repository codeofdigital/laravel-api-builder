<?php

namespace CodeOfDigital\ApiBuilder;

use Illuminate\Support\Facades\Config;

trait ApiLog
{
    /**
     * {@inheritdoc}
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * {@inheritdoc}
     */
    public function getConnectionName(): ?string
    {
        return Config::get('api-builder.drivers.database.connection');
    }

    /**
     * {@inheritdoc}
     */
    public function getTable(): string
    {
        return Config::get('api-builder.drivers.database.table', parent::getTable());
    }
}
