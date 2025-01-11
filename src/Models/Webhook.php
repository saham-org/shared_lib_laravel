<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Mongodb\Laravel\Eloquent\SoftDeletes;

class Webhook extends BaseModel
{
    use SoftDeletes ;

    protected $table = "webhook_calls";
    protected $fillable = [
        'name', 'url', 'headers', 'payload', 'exception',
    ];
}
