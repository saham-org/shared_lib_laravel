<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;

class UserTransaction extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;

    protected $casts = [
        'ref' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
