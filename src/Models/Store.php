<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Models\Enums\DeliveryFee;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\BelongsToArray;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Mongodb\Relations\HasOne;
use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\HasPaymentTypes;
use Saham\SharedLibs\Traits\HasWallet;
use Saham\SharedLibs\Traits\Translatable;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Database\Factories\StoreFactory;

class Store extends BaseModel
{
    use HasFactory;
    use Translatable;
    use HasWallet;
    use SoftDeletes;
    use HasPaymentTypes;
    use HasNotes ;

    protected $translatable = ['name', 'desc'];
    protected $attributes   = [
        'avg_rating'  => 4.9,
        'status'      => 'unavailable',
        'wallet'      => 0,
        'cuisine_ids' => [],
    ];
    protected $casts = [
        'latitude'          => 'double',
        'longitude'         => 'double',
        'max_delivery_time' => 'integer',
        'min_order_charge'  => 'integer',

    ];

    protected static function newFactory(): mixed
    {
        return StoreFactory::new();
    }

    public function getFullNameAttribute(): string
    {
        return $this->name_ar . ' ' . $this->code;
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function manager(): HasOne
    {
        return $this->hasOne(Manager::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'store_id');
    }
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'store_id');
    }

    public function cuisines(): BelongsToArray
    {
        return $this->belongsToArray(Cuisine::class, null, '_id', null, 'cuisine_ids');
    }

    public function scopeSearch($query, $keyword): void
    {
        $query->whereLike(['name_ar', 'name_en'], $keyword);
    }

    public function getCoupons(): ?Coupon
    {
        return Coupon::where('partner_ids', 'all', [$this->partner_id])
            ->where('display_public', '1')
            ->whereDate('promo_date_range.start', '<=', new UTCDateTime(new DateTime('now')))
            ->whereDate('promo_date_range.end', '>=', new UTCDateTime(new DateTime('now')))
            ->orderByDesc('created_at')->first();
    }

    public function getActiveCoupons(): mixed
    {
        return Coupon::where('partner_ids', 'all', [$this->partner_id])
         //   ->where('display_public', '1')
            ->whereDate('promo_date_range.start', '<=', new UTCDateTime(new DateTime('now')))
            ->whereDate('promo_date_range.end', '>=', new UTCDateTime(new DateTime('now')))
            ->orderByDesc('created_at')->get();
    }

    public function getFavorites(): ?int
    {
        return Favorite::where('store_id', $this->_id)->count();
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Banner::class, 'store_id');
    }

    public function runningStories(): mixed
    {
        return $this->stories()->where('image', null)->whereDate('banner_date_range.end', '>=', new UTCDateTime(new DateTime('now')));
    }

    public function scopeWithCommon($query, Request $request): void
    {
        $query->when($request->delivery_fee === 'Free', static function ($query): void {
            $query->whereHas('partner', static function ($query): void {
                $query->where('delivery_fee', DeliveryFee::Free->value);
            });
        })
            ->when($request->category_id, static function ($query) use ($request): void {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->cuisine_id, static function ($query) use ($request): void {
                $query->whereHas('partner', static function ($query) use ($request): void {
                    $query->where('cuisine_ids', 'all', [$request->cuisine_id]);
                });
            });
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function transactions(): mixed
    {
        return $this->hasMany(PartnerTransaction::class)
            ->orderByDesc('created_at');
    }

    public function acceptsService(string $deliver_type): bool
    {
        // if ($deliver_type === 'delivery') {
        //     return $this->services['delivery'];
        // }

        // if ($deliver_type === 'receipt') {
        //     return $this->services['pickup'];
        // }

        // if ($deliver_type === 'reservation') {
        //     return $this->services['reservation'];
        // }
        return getStoreServices($this, true)[$deliver_type] ?? true;
    }


    function updateStoreService($pickup = null, $delivery = null, $feasts = null, $reservation = null): mixed
     {
        $services = $this->services;

        if ($pickup !== null) {
            $services['pickup'] = $pickup === true || $pickup === 1;
        }

        if ($delivery !== null) {
            $services['delivery'] = $delivery === true || $delivery === 1;
        }

        if ($feasts !== null) {
            $services['feasts'] = $feasts === true || $feasts === 1;
        }

        if ($reservation !== null) {
            $services['reservation'] = $reservation === true || $reservation === 1;
        }

         return   $this->update(['services' => $services]);
    }
}
