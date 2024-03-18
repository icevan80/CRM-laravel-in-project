<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'edit_self',
        'edit_other',
        'edit_date_self',
        'edit_date_other',
        'create_appointment',
        'delete_appointment',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
