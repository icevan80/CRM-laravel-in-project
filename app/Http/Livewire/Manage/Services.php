<?php

namespace App\Http\Livewire\Manage;

use App\Models\Service;
use Livewire\Component;

class Services extends Component
{
    public $search;

    public $confirmingServiceDeletion = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $services = Service::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('slug', 'like', '%'.$this->search.'%')
                ->orWhere('note', 'like', '%'.$this->search.'%')
                ->orWhere('price', 'like', '%'.$this->search.'%')
                ->orWhere('max_price', 'like', '%'.$this->search.'%')
                ->orWhereHas('category', function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                });
        })
            ->orderByPrice('PriceLowToHigh')
            ->with('category')
            ->where('status', true)
            ->paginate(10);

        $categories = \App\Models\Category::all();

        return view('livewire.manage.services', compact('services'), compact('categories'));
    }

    public function confirmServiceDeletion($id)
    {
        $this->confirmingServiceDeletion = $id;
    }
}
