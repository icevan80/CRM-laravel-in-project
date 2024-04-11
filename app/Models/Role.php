<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'default_permissions',
        'status',
    ];

    static function getRole($search) {
        $table = Role::all();
        if (gettype($search) == 'string') {
            return $table->where('name', $search)->first();
        } else if (gettype($search) == 'integer') {
            return $table->where('id', $search)->first();
        }
    }

    public function permissions(): array
    {
        return json_decode($this->default_permissions, true);
    }

    public function jsonPermissions(): string
    {
        return $this->default_permissions;
    }

    public function removePermission($permission): bool
    {
        $result = false;
        if ($permission != null) {
            $array = $this->permissions();
            unset($array[$permission->id]);
            $this->default_permissions = json_encode($array);
            $result = $this->save();
        }
        return $result;
    }

    public function addPermission($permission): bool
    {
        $result = false;
        if ($permission != null) {
            $array = $this->permissions();
            $array[$permission->id] = $permission->code_name;
            $this->default_permissions = json_encode($array);
            $result = $this->save();
        }
        return $result;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            $role->default_permissions = json_encode(array());
        });
    }
}
