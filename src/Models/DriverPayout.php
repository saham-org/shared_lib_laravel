<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;

class DriverPayout extends BaseModel
{
    use HasFactory;

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
