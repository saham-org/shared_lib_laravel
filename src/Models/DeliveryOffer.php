<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\Translatable;

class DeliveryOffer extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    use Translatable;
    protected $guarded = [];
    protected $table = 'delivery_offers';
    protected $translatable = ['name'] ;

    public function deliveryOffersStore(): HasMany
    {
        return $this->hasMany(DeliveryOfferStore::class);
    }
    public function deliveryOffersDriver(): HasMany
    {
        return $this->hasMany(DeliveryOfferDriver::class);
    }

    public function setImageAttribute($value): void
    {
        $this->attributes['image'] = storeImage($value, 'delivery_offers', 'offers');
    }

}