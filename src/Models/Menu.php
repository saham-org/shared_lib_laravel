<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\MenuFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Mongodb\Relations\HasOne;
use Saham\SharedLibs\Traits\Translatable;

class Menu extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['title'];

    protected static function newFactory(): MenuFactory
    {
        return MenuFactory::new();
    }

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

    public function feastProducts(): HasMany
    {
        return $this->hasMany(FeastProduct::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
