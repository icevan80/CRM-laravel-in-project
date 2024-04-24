<?php

namespace App\Http\Livewire\Manage;

use App\Models\Service;
use Livewire\Component;

class Services extends Component
{
    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $services = Service::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('slug', 'like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%')
                ->orWhere('price', 'like', '%'.$this->search.'%')
                ->orWhereHas('category', function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                });
        })
            ->orderByPrice('PriceLowToHigh')
            ->with('category')
            ->paginate(10);

        $categories = \App\Models\Category::all();

        return view('livewire.manage.services', compact('services'), compact('categories'));
    }
}
