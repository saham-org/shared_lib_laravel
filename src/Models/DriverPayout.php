<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverPayout extends BaseModel
{
    use HasFactory;

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
