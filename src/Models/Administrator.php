<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Saham\SharedLibs\Mongodb\Eloquent\Model as Eloquent;
// use Saham\SharedLibs\Traits\HasRoles;
use Saham\SharedLibs\Traits\HasRoles;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class Administrator extends Eloquent implements Authenticatable, AuthorizableContract
{
    use AuthenticatableTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Authorizable;
    use HasRoles;
    use InteractsWithMedia;

    protected $fillable = [
        'full_name', 'email', 'phone', 'avatar',  'password', 'freeze', 'role', 'device_id', 'device_type', 'notification_id', 'os_version', 'role_ids',
    ];
    protected $primaryKey = '_id';
    protected $connection = 'mongodb';
    protected $guarded    = [];
    protected $table      = 'administrators';
    protected $attribute  = ['avatar' => 'assets/images/users/saham.jpg'];
    protected $hidden     = ['password'];

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [];

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array<string>
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
