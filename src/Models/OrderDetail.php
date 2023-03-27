<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\EmbedsMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends BaseModel
{
    use HasFactory;

    protected $with    = ['product'];
    public $timestamps = false;

    public function variations(): EmbedsMany
    {
        return $this->embedsMany(ProductVariation::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
