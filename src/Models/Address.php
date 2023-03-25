<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use SahamLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Geocoder\Facades\Geocoder;

class Address extends BaseModel
{
    use HasFactory;
    use Translatable;

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
