<?php

namespace App\Http\Livewire\Manage;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    private $categories;

    public int $categoryId = 0;
    public $selectedCategory;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public bool $confirmEditCategory = false;
    public bool $confirmDeleteCategory = false;

    public function render()
    {
        $categories = Category::when($this->search, function ($subQuery) {
            $subQuery->where('name', 'like', '%' . $this->search . '%');
        })->where('status', true)
            ->paginate(5);

        return view('livewire.manage.categories', compact('categories'));
    }

    public function confirmCategoryEdit($category)
    {
        $this->selectedCategory = $category;
        $this->fill(['categoryId' => $category['id']]);
        $this->fill(['confirmEditCategory' => true]);
    }

    public function confirmCategoryDeletion($categoryId)
    {
        $this->fill(['categoryId' => $categoryId]);
        $this->fill(['confirmDeleteCategory' => true]);
    }
}
