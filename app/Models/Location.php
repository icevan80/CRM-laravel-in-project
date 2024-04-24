<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $casts = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'address',
        'telephone_number',
        'operate',
        'status',
    ];


}
