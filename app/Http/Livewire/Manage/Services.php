<?php

namespace App\Http\Livewire\Manage;

use App\Models\Category;
use App\Models\Master;
use App\Models\Service;
use Livewire\Component;

class Services extends Component
{
    public $search;

public $categories;
public $masters;
public $selectedService;

    public $confirmingServiceDeletion = false;
    public $confirmingServiceEdition = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount() {
        $this->categories = Category::all();
        $this->masters = Master::all();
    }

    public function render()
    {
        $services = Service::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('slug', 'like', '%'.$this->search.'%')
                ->orWhere('notes', 'like', '%'.$this->search.'%')
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

        return view('livewire.manage.services', compact('services'));
    }

    public function confirmServiceDeletion($id)
    {
        $this->confirmingServiceDeletion = $id;
    }

    public function confirmingServiceEdition($id)
    {
        $this->confirmingServiceEdition = $id;
        $this->selectedService =         $this->service = Service::where('id', $id)->first();
    }
}
