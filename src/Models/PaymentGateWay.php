<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentGateWay extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'supplier_name',
        'email',
        'mobile',
        'commission_value',
        'percentage_net_value',
        'bank_id',
        'set_default',
        'bank_account_holder_name',
        'bank_account',
        'iban',
        'related_id',
        'related_type',
        'imgs',
        ];

}
