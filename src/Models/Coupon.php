<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;

class Coupon extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;

    protected $casts = [
        'amount'         => 'double',
        'value'          => 'double',
        'minimum_amount' => 'double',
        'radius'         => 'double',
    ];

    protected $fillable = [
        'name','partner_ids' , 'show_first' ,'type_discount','amount','code','minimum_amount','users_id','users_date_range','promo_date_range','limit_per_user','global_limit','radius','latitude','longitude','send_code','display_public',
    ];
    protected $dates = ['deleted_at'];

    protected static function booted(): void
    {
        static::addGlobalScope('delete', static function (Builder $builder): void {
            $builder->where('deleted_at', null);
        });
    }

    public static function findByCode($code): ?self
    {
        return self::where('code', $code)->first();
    }

    public function isValid(): bool
    {
        return $this->global_limit === null || $this->global_limit === -1 || $this->global_limit > $this->global_use;
    }

    public function isInDateRange(): bool
    {
        if ($this->promo_date_range) {
            $now   = new DateTime();

            if ($this->promo_date_range['end'] && $this->promo_date_range['end'] instanceof UTCDateTime) {
                if ($this->promo_date_range['end']->toDateTime() < $now) {
                    return false;
                }
            }

            if (
                $this->promo_date_range['start']
                && $this->promo_date_range['start'] instanceof UTCDateTime
            ) {
                if ($this->promo_date_range['start']->toDateTime() > $now) {
                    return false;
                }
            }
        }

        return true;
    }

    public function isInArea(float $latitude, float $longitude): bool
    {
        $distance = directDistance($latitude, $longitude, $this->latitude, $this->longitude);

        return $distance <= $this->radius;
    }

    public function isForUser(string $userId): bool
    {
        $forUser = true;

        if ($this->users_id && is_array($this->users_id)) {
            $forUser = in_array($userId, $this->users_id, true) || in_array('all', $this->users_id, true);
        }

        $haveLimit = true;

        if ($this->limit_per_user !== null && intval($this->limit_per_user) > 0) {
            $userUse   =  array_count_values($this->used_by ?? [])[$userId] ?? 0;
            $haveLimit = $userUse < intval($this->limit_per_user);
        }

        return $haveLimit && $forUser;
    }

    public function isForPartner(string $partner_id): bool
    {
        if ($this->partner_ids && is_array($this->partner_ids)) {
            return in_array('all', $this->partner_ids, true) || in_array($partner_id, $this->partner_ids, true);
        }

        return true;
    }

    public function isForStore(string $store_id): bool
    {
        $store = Store::find($store_id);

        if ($this->partner_ids && is_array($this->partner_ids)) {
            return in_array('all', $this->partner_ids, true) || in_array($store->partner_id, $this->partner_ids, true);
        }

        return true;
    }

    public function isForTotal(float $total): bool
    {
        return $total >= $this->minimum_amount;
    }

    public function markAsUsedForUser($userId): ?self
    {
        $this->push('used_by', $userId);
        $this->increment('global_use');
        $this->save();

        return $this;
    }

    public function calculateDiscount(float $sub_total, ?float $delivery_fee = null): float
    {
        return $this->type_discount === 'percentage' && $this->amount <= 100 ?
            $this->amount * $sub_total / 100 : ($this->type_discount === 'percentage_delivery' ? $this->amount * $delivery_fee / 100 : $this->amount);
    }
}
