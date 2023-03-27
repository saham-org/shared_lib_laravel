<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerTransaction extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'ref' => 'string',
    ];
}
