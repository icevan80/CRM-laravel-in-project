<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferences extends Model
{
    protected $fillable = [
        'manage_appointment',
        'create_appointment',
        'edit_appointment',
        'edit_date_appointment',
        'delete_appointment',
        'edit_other_appointment',
        'edit_translations',
        'manage_users',
        'manage_locations',
        'manage_services',
        'manage_categories',
        'manage_deals',
        'edit_preferences',
        'edit_users',
        'edit_locations',
        'edit_services',
        'edit_categories',
        'edit_deals',
    ];

    protected $casts = [
        'manage_appointment' => 'boolean',
        'create_appointment' => 'boolean',
        'edit_appointment' => 'boolean',
        'edit_date_appointment' => 'boolean',
        'delete_appointment' => 'boolean',
        'edit_other_appointment' => 'boolean',
        'edit_translations' => 'boolean',
        'manage_users' => 'boolean',
        'manage_locations' => 'boolean',
        'manage_services' => 'boolean',
        'manage_categories' => 'boolean',
        'manage_deals' => 'boolean',
        'edit_preferences' => 'boolean',
        'edit_users' => 'boolean',
        'edit_locations' => 'boolean',
        'edit_services' => 'boolean',
        'edit_categories' => 'boolean',
        'edit_deals' => 'boolean',
    ];
}
