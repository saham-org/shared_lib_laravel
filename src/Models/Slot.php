<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;

class Slot extends BaseModel
{

    use SoftDeletes ;
    
    protected $fillable = [
        'unit_id', 'from', 'to', 'status'
    ];
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
