<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Eloquent\Builder;
use SahamLibs\Mongodb\Relations\BelongsTo;
use SahamLibs\Mongodb\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{
    use HasFactory;

    protected $guarded    = [];
    protected $attributes = [
        'status'    => 'pending',
        'cash_paid' => false,
    ];

    protected $casts = [
        'ref_id' => 'string',
    ];

    public function scopeCurrentStatus($query, $status): Builder
    {
        if ($status === 'pending_driver') {
            $query->whereStatus('pending')
                ->whereNull('driver_id');
        } elseif ($status === 'pending_store') {
            $query->whereStatus('pending')
                ->whereNotNull('driver_id');
        } else {
            $query->where('status', $status);
        }

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
