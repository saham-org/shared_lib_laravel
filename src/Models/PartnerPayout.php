<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;

class PartnerPayout extends BaseModel
{
    use HasFactory;

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
