<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deliver extends BaseModel
{
    use HasFactory;

    protected $dates = ['delivered_at'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(DeliverItem::class, 'item_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(DeliverSize::class, 'size_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
