<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;

class Messaging extends BaseModel
{
    use SoftDeletes ;

    protected $fillable = [
        'data', 'from', 'to', 'status', 'cc', 'view', 'message', 'subject', 'title', 'response', 'exception'
    ];

}
