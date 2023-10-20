<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\CategoryFactory;

class CashoutMethods extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'supplier_name',
        'email',
        'mobile',
        'commission_value',
        'percentage_net_value',
        'bank_id',
        'bank_account_holder_name',
        'bank_account',
        'iban',
        'images',
        'set_default'

    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}