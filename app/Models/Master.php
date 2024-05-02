<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $fillable = [
        'user_id',
    ];

    function user() {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'services_masters', 'master_id', 'service_id');
    }
}
