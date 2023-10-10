<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Traits\HasNotes;

/**
 * Summary of Order.
 */
class PendingOrder extends BaseModel
{
    use HasFactory;
    use HasNotes;

    protected $guarded    = [];
    protected $attributes = [
        'status'    => 'pending',
        'cash_paid' => false,
    ];

    protected $casts = [
        'ref_id' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}