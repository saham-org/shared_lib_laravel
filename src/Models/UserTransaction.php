<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Mongodb\Laravel\Eloquent\SoftDeletes;
use Mongodb\Laravel\Relations\BelongsTo;

class UserTransaction extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;

    protected $casts = [
        'ref' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
