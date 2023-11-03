<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Traits\HasNotes;

class Deliver extends BaseModel
{
    use HasFactory;
    use HasNotes ;

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
