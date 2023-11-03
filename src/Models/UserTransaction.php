<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
