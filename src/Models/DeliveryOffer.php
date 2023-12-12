<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\HasMany;

class DeliveryOffer extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    protected $guarded = [];
    protected $table = 'delivery_offers';

    public function storeDeliveryOffers(): HasMany
    {
        return $this->hasMany(StoreDeliveryOffer::class);
    }
    public function driverDeliveryOffers(): HasMany
    {
        return $this->hasMany(DriverDeliveryOffer::class);
    }

    public function setImageAttribute($value): void
    {
        $this->attributes['image'] = storeImage($value, 'delivery_offers', 'offers');
    }

}