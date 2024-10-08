<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Traits\Translatable;

class Product extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['title', 'desc'];

    protected $guarded = [];

    public function variations(): mixed
    {
        return $this->hasMany(ProductVariation::class, 'product_id', '_id');
    }

    public function menu(): mixed
    {
        return $this->belongsTo(Menu::class);
    }

    public function sizes(): mixed
    {
        return $this->embedsMany(Size::class);
    }

    public function scopeAvailableOnly($query): void
    {
        $query->where('status', 'available');
    }

    public function logProductPriceUpdate($thing_name, $thing_price_from, $thing_price_to, $status_from = null): void
    {

        self::withoutEvents(function () use ($thing_name, $thing_price_from, $thing_price_to, $status_from): void {
            $this->push('changes', [
                'price_from'  => $thing_price_from,
                'price_to'    => $thing_price_to,
                'status_from' => $status_from,
                'status_to'   => 'pending',
                'item'        => $thing_name,
            ], false);

            $this->update([
                'status'  => 'pending',
            ]);
        });
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Driver::class, 'related_id')->where('related_type', Product::class);
    }
}
