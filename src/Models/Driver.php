<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Enums\OrderStatus;
use SahamLibs\Mongodb\Eloquent\Model as Eloquent;
use SahamLibs\Mongodb\Relations\BelongsTo;
use SahamLibs\Mongodb\Relations\HasMany;
use SahamLibs\Traits\HasTransaction;
use SahamLibs\Traits\HasWallet;
use SahamLibs\Traits\Translatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class Driver extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Translatable;
    use HasWallet;
    use HasTransaction;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'under_revision',
    ];

    protected $hidden = ['remember_token', 'password'];

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function findForPassport($username): ?self
    {
        return $this->where('phone', $username)->first();
    }

    public function routeNotificationForSms($notifiable): string
    {
        return $this->phone;
    }

    public function routeNotificationForFcm($notifiable): string
    {
        return $this->notification_id;
    }

    public function setCarFrontAttribute($value): void
    {
        $this->attributes['car_front'] = storeImage($value, 'driver', 'car');
    }

    public function setCarBackAttribute($value): void
    {
        $this->attributes['car_back'] = storeImage($value, 'driver', 'car');
    }

    public function setIDPhotoAttribute($value): void
    {
        $this->attributes['ID_photo'] = storeImage($value, 'driver', 'ID');
    }

    public function setCarRegisterAttribute($value): void
    {
        $this->attributes['car_register'] = storeImage($value, 'driver', 'Car');
    }

    public function setLicenseAttribute($value): void
    {
        $this->attributes['license'] = storeImage($value, 'driver', 'license');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function activeOrder(): HasMany
    {
        return $this->hasMany(Order::class)
            ->whereIn('status', OrderStatus::onlyActive());
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(DriverTransaction::class)
            ->orderByDesc('created_at');
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(DriverPayout::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(DriverAssignment::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
