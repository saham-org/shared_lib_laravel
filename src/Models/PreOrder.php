<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Mongodb\Laravel\Relations\BelongsTo;
use Mongodb\Laravel\Relations\HasMany;
use Saham\SharedLibs\Traits\HasNotes;

class PreOrder extends BaseModel
{
    use HasNotes ;

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

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }
}
