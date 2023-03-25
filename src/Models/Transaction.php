<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'ref' => 'string',
    ];
}
