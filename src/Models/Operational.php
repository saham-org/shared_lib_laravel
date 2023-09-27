<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Mongodb\Eloquent\Model as Eloquent;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\HasTransaction;
use Saham\SharedLibs\Traits\HasWallet;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class Operational extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasTransaction;
    use Translatable;
    use HasWallet;
    use HasNotes ;


    protected $attributes = [
        'status' => 'under_revision',
    ];

    protected $guarded = [];

    protected $hidden = ['remember_token', 'password'];

    protected $fillable = [
          'full_name', 'email'
        , 'phone', 'avatar', 'password', 'phone_code'
        , 'bank_name' , 'bank_IBAN' , 'system_driver_commission_percentage'
        , 'system_driver_commission_amount'
        ,  'block'
        ,  'wallet'
        , 'status'
        ,'rang_kilo'
        ,'time_to_assign'
        , 'auto_assign'
        , 'notification_id'
        , 'device_id'
        , 'device_type'
        , 'os_version'
        , 'notes_history'
    ];

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function findForPassport($username): ?self
    {
        return $this->where('email', $username)->first();
    }

    public function routeNotificationForFcm($notifiable): string
    {
        return $this->notification_id;
    }


    public function payouts(): HasMany
    {
        return $this->hasMany(OperationalPayout::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(OperationalTransaction::class)
            ->orderByDesc('created_at');
    }

}
