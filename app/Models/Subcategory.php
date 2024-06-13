<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name',
        'presentation_name',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    static function boot()
    {
        parent::boot();

        static::creating(function ($subcategory) {
            $subcategory->full_name = $subcategory->category->name.' ('.$subcategory->name.')';
        });
    }
}
