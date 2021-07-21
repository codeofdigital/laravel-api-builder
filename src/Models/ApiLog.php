<?php

namespace CodeOfDigital\ApiBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model implements \CodeOfDigital\ApiBuilder\Contracts\ApiLog
{
    use \CodeOfDigital\ApiBuilder\ApiLog;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'request_header' => 'array',
        'request' => 'array',
        'response_header' => 'array',
        'response' => 'array'
    ];
}
