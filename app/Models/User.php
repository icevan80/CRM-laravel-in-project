<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    function role() {
        return $this->belongsTo(Role::class);
    }

    function cart() {
        return $this->hasOne(Cart::class);
    }

    function hasPermission(int $id) :bool {
        return array_key_exists($id, Json::decode($this->permissions, true));
    }

    function addPermission(int $id) :bool{
        $result = true;
        $permission = Permission::all()->where('id', $id);
        if (count($permission) > 0) {
            if (!$this->permissions->contains($id)) {
                $this->permissions += [$id => $permission->first()->name];
                $this->save();
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /*function removePermission(int $id) :bool{
        $result = true;
            if ($this->permissions->contains($id)) {
                $this->permissions ;
                $this->save();
            }
        } else {
            $result = false;
        }
        return $result;
    }*/

    static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // a readable unique code for the appointment, including the id in the code
            $user->permission = $user->role->default_permission;

        });
    }
}

