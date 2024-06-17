<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'appointment_code',
        'creator_id',
        'implementer_id',
        'client_id',
        'receiving_name',
        'receiving_description',
        'date',
        'start_time',
        'end_time',
        'location_id',
        'service_id',
        'total',
        'referral',
        'complete',
        'status',
    ];

    protected $casts = [
        'start_time' => 'string',  // as string cuz we get it from the time slot
        'end_time' => 'string',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function implementer()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->client->user;
    }



    static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            // a readable unique code for the appointment, including the id in the code
            $appointment->appointment_code = 'APP-'. ($appointment->count() + 1);

        });
    }


}
