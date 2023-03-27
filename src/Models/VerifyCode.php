<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerifyCode extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function scopeVerify($query, $phone, $code): void
    {
        $query->where('phone', $phone)->where('code', $code);
    }
}
