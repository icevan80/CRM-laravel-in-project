<?php

namespace App\Models;

use App\Jobs\SendNewServicePromoMailJob;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $perPage = 10;

//    protected $hidden = [
//        'id',
//        'category_id',
//        'is_hidden',
//        'created_at',
//        'updated_at',
//    ];
    protected $fillable = [
//        'uuid',
        'name',
        'slug',
        'image',
        'price',
        'max_price',
        'notes',
        'type',
        'duration_minutes',
        'category_id',
        'is_hidden',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    public function masters()
    {
        return $this->belongsToMany(Master::class, 'services_masters', 'service_id', 'master_id');
    }

    public function getMasters() {
        return $this->belongsToMany(Master::class, 'services_masters')->withPivot('service_id');
    }

    // is visible
    public function scopeIsVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    public function scopeOrderByPrice($query, $order)
    {
        if ($order === 'PriceLowToHigh') {
            return $query->orderBy('price', 'asc');
        } elseif ($order === 'PriceHighToLow') {
            return $query->orderBy('price', 'desc');
        }

        // default is PriceLowToHigh
        return $query->orderBy('price', 'asc');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function hits()
    {
        return $this->hasMany(ServiceHit::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'cart_service')
            ->withPivot('location_id');
    }

    protected static function booted()
    {
//        static::creating(function ($service) {
//            $service->uuid = (string) \Illuminate\Support\Str::uuid();
//        });

        static::created(function ($service) {

            // if service is hidden, don't send email
            if ($service->is_hidden) {
                return;
            }

            $customers = User::where('role_id', Role::getRole('Customer')->id)->where('status', true)->get();

            foreach ($customers as $customer) {

                dispatch(new SendNewServicePromoMailJob($customer, $service));
            }
        });
    }


}
