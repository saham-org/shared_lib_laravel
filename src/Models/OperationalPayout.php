<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;

class OperationalPayout extends BaseModel
{
    use HasFactory;

    public function operational(): BelongsTo
    {
        return $this->belongsTo(Operational::class);
    }
}
