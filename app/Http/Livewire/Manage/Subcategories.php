<?php

namespace App\Http\Livewire\Manage;

use App\Models\Subcategory;
use Livewire\Component;

class Subcategories extends Component
{
    private $subcategories;

    public int $subcategoryId = 0;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public bool $confirmEditSubcategory = false;
    public bool $confirmDeleteSubcategory = false;

    public function render()
    {
        $subcategories = Subcategory::when($this->search, function ($subQuery) {
            $subQuery->where('name', 'like', '%' . $this->search . '%');
        })->where('status', true)
            ->paginate(25);

        return view('livewire.manage.subcategories', compact('subcategories'));
    }

    public function confirmSubcategoryEdit($subcategoryId)
    {
        $this->fill(['subcategoryId' => $subcategoryId]);
        $this->fill(['confirmEditSubcategory' => true]);
    }

    public function confirmSubcategoryDeletion($subcategoryId)
    {
        $this->fill(['subcategoryId' => $subcategoryId]);
        $this->fill(['confirmDeleteSubcategory' => true]);
    }
}
