<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverPayout extends BaseModel
{
    use HasFactory;

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
