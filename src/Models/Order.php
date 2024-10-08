<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Models\Enums\OrderStatus;
use Saham\SharedLibs\Mongodb\Eloquent\Builder;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\StateMachines\OrderStatusMachine;
use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\HasStateMachines;

/**
 * Main Order model
 */
class Order extends BaseModel
{
    use HasFactory;
    use HasNotes;
    use HasStateMachines;

    /**
     * `status` State Machines
     * @var array
     */
    public $stateMachines = [
        'status' => OrderStatusMachine::class
    ];

    protected $guarded = [];
    protected $attributes = [
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

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'order_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /*  public function coupon(): HasOne
      {
          return $this->hasOne(Coupon::class, 'coupon', 'code');
      }*/

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    public function couponDetails(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon', 'code');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'order_id');
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(UserTransaction::class, 'order_id');
    }

    public function userOrderTransaction(): HasMany
    {
        return $this->hasMany(UserTransaction::class, 'order_id');
    }
}
