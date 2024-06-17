<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'email',
        'notes',
    ];

    function user()
    {
        return $this->hasOne(User::class);
    }

    static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            if ($client->name == null
                && $client->phone_number == null
                && $client->email == null) {
                $user = User::findOrFail($client->user_id);
                $client->name = $user->name;
                $client->phone_number = $user->phone_number;
                $client->email = $user->email;
            }
        });
    }
}
