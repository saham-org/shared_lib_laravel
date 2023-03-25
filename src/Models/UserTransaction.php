<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTransaction extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;

    protected $casts = [
        'ref' => 'string',
    ];
}
