<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeastProduct extends Product
{
    use HasFactory;

    protected $extra_fields = ['max_allowed_size', 'min_allowed_size'];

    public function variations(): mixed
    {
        return $this->hasMany(ProductVariation::class, 'feast_product_id', '_id');
    }
}
