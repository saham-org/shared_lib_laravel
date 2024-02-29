<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Saham\SharedLibs\Models\Enums\OrderStatus;
use Saham\SharedLibs\Mongodb\Eloquent\Model as Eloquent;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\HasTransaction;
use Saham\SharedLibs\Traits\HasWallet;
use Saham\SharedLibs\Traits\Translatable;

class Driver extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Translatable;
    use HasWallet;
    use HasTransaction;
    use HasNotes ;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'under_revision',
    ];

    protected $fillable = [
        'status',
        'phone',
        'full_name',
        'city_id',
        'email',
        'password',
        'ID',
        'car_front',
        'car_back',
        'ID_photo',
        'license',
        'car_register',
        'device_id',
        'notification_id',
        'device_type',
        'os_version',
        'services' ,
        'location',
        'latitude',
        'longitude',
        'bank_IBAN',
        'bank_name',
        'wallet',
        'operation_manger_id',
        'hiring_type',
        'ID_number',
        'gender',
        'notes_history' ,
        'block',
        'account_status',
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

    public function ratings(): HasMany
    {
        return $this->hasMany(Driver::class, 'related_id')->where('related_type', Driver::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function operational(): BelongsTo
    {
        return $this->belongsTo(Operational::class, 'operation_manger_id');
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complaint::class, 'related_id', '_id')->where('related_type', Driver::class);
    }

    public function cashoutMethods(): HasMany
    {
        return $this->hasMany(CashoutMethods::class, 'related_id', '_id')->where('related_type', Driver::class);
    }

    public function acceptsService(string $service): bool
    {
        return getDriverServices($this, true)[$service] ?? true;
    }

    public function updateService($special_order = null, $normal_order = null, $feasts = null, $reservations = null): mixed
    {
        $services = $this->services;

        if ($special_order !== null) {
            $services['special_order'] = $special_order === true || $special_order === 1;
        }

        if ($normal_order !== null) {
            $services['normal_order'] = $normal_order === true || $normal_order === 1;
        }

        if ($feasts !== null) {
            $services['feasts'] = $feasts === true || $feasts === 1;
        }


        return   $this->update(['services' => $services]);
    }
}