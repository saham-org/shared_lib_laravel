<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;

class VerifyCode extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function scopeVerify($query, $phone, $code): void
    {
        $query->where('phone', $phone)->where('code', $code);
    }
}
