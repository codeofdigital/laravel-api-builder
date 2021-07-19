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
}
