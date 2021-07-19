<?php

namespace CodeOfDigital\ApiBuilder\Contracts;

interface ApiLog
{
    /**
     * User responsible for the changes.
     *
     * @return mixed
     */
    public function user();

    /**
     * Get the current connection name for the model.
     *
     * @return string|null
     */
    public function getConnectionName(): ?string;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string;
}
