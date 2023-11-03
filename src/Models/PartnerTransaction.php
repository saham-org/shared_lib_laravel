<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;

class PartnerTransaction extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'ref' => 'string',
    ];
}
