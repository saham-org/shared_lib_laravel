<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerPayout extends BaseModel
{
    use HasFactory;

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
