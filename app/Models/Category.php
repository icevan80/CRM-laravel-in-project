<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image',
    ];

    static function getCategory($search) {
        $table = Category::all();
        if (gettype($search) == 'string') {
            return $table->where('name', $search)->first();
        } else if (gettype($search) == 'integer') {
            return $table->where('id', $search)->first();
        }
    }

    public function getSubcategory($search) {
        $subcategories = $this->subcategories;
        if (gettype($search) == 'string') {
            return $subcategories->where('name', $search)->first();
        } else if (gettype($search) == 'integer') {
            return $subcategories->where('id', $search)->first();
        }
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
