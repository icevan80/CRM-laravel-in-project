<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'code_name',
        'status',
    ];

    static function getPermission($search) {
        $table = Permission::all();
        if (gettype($search) == 'string') {
            return $table->where('code_name', $search)->first();
        } else if (gettype($search) == 'integer') {
            return $table->where('id', $search)->first();
        }
    }

    static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            $permission->code_name = str_replace(" ", "_", trim(strtolower($permission->name)));
        });
    }
}
