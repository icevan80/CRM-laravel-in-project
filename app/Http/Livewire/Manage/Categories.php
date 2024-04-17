<?php

namespace App\Http\Livewire\Manage;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    private $categories;

    public int $categoryId = 0;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public bool $confirmEditCategory = false;
    public bool $confirmDeleteCategory = false;

    public function render()
    {
        $query = Category::when($this->search, function ($subQuery) {
            $subQuery->where('name', 'like', '%' . $this->search . '%');
        });
        $this->categories = $query->where('status', true)->paginate(25);

        return view('livewire.manage.categories', [
            'categories' => $this->categories,
        ]);
    }

    public function confirmCategoryEdit($categoryId)
    {
        $this->fill(['categoryId' => $categoryId]);
        $this->fill(['confirmEditCategory' => true]);
    }

    public function confirmCategoryDeletion($categoryId)
    {
        $this->fill(['categoryId' => $categoryId]);
        $this->fill(['confirmDeleteCategory' => true]);
    }
}
