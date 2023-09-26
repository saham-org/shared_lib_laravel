<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperationalPayout extends BaseModel
{
    use HasFactory;

    public function operational(): BelongsTo
    {
        return $this->belongsTo(Operational::class);
    }
}