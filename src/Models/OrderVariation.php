<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderVariation extends BaseModel
{
    use HasFactory;

    protected $with    = ['productVariation'];
    public $timestamps = false;

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }
}
