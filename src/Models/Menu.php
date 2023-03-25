<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use SahamLibs\Mongodb\Relations\HasMany;
use SahamLibs\Mongodb\Relations\HasOne;
use SahamLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['title'];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'partner_id', 'partner_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
