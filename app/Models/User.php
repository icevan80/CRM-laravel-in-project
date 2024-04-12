<?php

namespace App\Models;

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
        'permission',
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

    function updateRole($newRole) {
        $this->role_id = $newRole->id;
        return $this->save();
    }

    public function permissions(): array
    {
        $customPermissions = $this->personalPermissions();
        $rolePermissions = $this->role->permissions();
        foreach ($customPermissions as $key => $permission) {
            if ($permission['approve']) {
                $rolePermissions[$key] = $permission['code_name'];
            } else if (array_key_exists($key, $rolePermissions)){
                unset($rolePermissions[$key]);
            }
        }

        return $rolePermissions;
    }

    public function personalPermissions(): array
    {
        return json_decode($this->permissions, true);;
    }

    function hasPermission($code) :bool {
        $array = $this->permissions();
        $permission = Permission::getPermission($code);
        if ($permission == null) {
            return false;
        } else if ($permission->status == false) {
            return false;
        }
        if (gettype($code) == 'string') {
            return array_search($code, $array) > 0;
        } else {
            return array_key_exists($code, $array);
        }
    }

    public function removePermissionRule($permission): bool
    {
        $result = false;
        if ($permission != null) {
            $array = $this->personalPermissions();
            if (array_key_exists($permission->id, $array)) {
                unset($array[$permission->id]);
                $this->permissions = json_encode($array);
                $result = $this->save();
            } else {
                $result = true;
            }
        }
        return $result;
    }

    public function addPermissionRule($permission, bool $approve): bool
    {
        if ($approve == null) {
            return $this->removePermissionRule($permission);
        }
        $result = false;
        if ($permission != null) {
            $array = $this->personalPermissions();
            $array[$permission->id] = array('code_name' => $permission->code_name, 'approve' => $approve);
            $this->permissions = json_encode($array);
            $result = $this->save();
        }
        return $result;
    }

    static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->permissions = json_encode(array());

        });
    }
}

