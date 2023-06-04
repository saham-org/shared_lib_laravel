<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;

class Slot extends BaseModel
{
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
