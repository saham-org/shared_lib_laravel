<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Mongodb\Relations\HasOne;
use Saham\SharedLibs\Traits\Translatable;
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
