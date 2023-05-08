<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\OrderFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\Builder;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;

/**
 * Summary of Order
 */
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

    /**
     * Summary of newFactory
     */
    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }

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
