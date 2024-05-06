<?php

namespace App\Http\Livewire\Web;

use App\Models\Category;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component
{
    use WithPagination;

    public $search;
    public $categories;
    public $categoryFilter = [];
    public $sortByPrice = 'PriceLowToHigh';

    public $sortDropDown;

    private $services;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => []],
        'sortDropDown' => ['except' => 'PriceLowToHigh'],
    ];

    public function mount()
    {
        $this->categories = Category::all()->where('status', true);

        // Initialize categoryFilter with all category IDs
        $this->categoryFilter = $this->categories->pluck('id')->toArray();
    }

    public function render()
    {
        $query = Service::query();

        if ($this->search) {
            $query->where(function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if (!in_array(0, $this->categoryFilter)) {
            // Exclude 0 (which represents "All" category) from the filter
            $query->whereIn('category_id', $this->categoryFilter);
        }

        // Determine whether to show category names in the URL or not
        $showCategoryNames = count($this->categoryFilter) <= 3;

        $this->services = $query->orderByDesc('price')->paginate();

        return view('livewire.web.services', [
            'services' => $this->services,
            'categories' => $this->categories,
            'showCategoryNames' => $showCategoryNames, // Pass this variable to your view
        ]);
    }
}
