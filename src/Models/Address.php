<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\AddressFactory;
use Spatie\Geocoder\Facades\Geocoder;

class Address extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected static function newFactory()
    {
        return AddressFactory::new();
    }


    protected $translatable = ['formatted_address'];

    protected $casts = [
        'latitude'  => 'double',
        'longitude' => 'double',
    ];

    public function setFormattedAddressArAttribute($value = null): void
    {
        $this->attributes['formatted_address_ar'] = Geocoder::setLanguage('ar')
        ->getAddressForCoordinates($this->latitude, $this->longitude)['formatted_address'];
    }

    public function setFormattedAddressEnAttribute($value = null): void
    {
        $this->attributes['formatted_address_en'] = Geocoder::setLanguage('en')
        ->getAddressForCoordinates($this->latitude, $this->longitude)['formatted_address'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
