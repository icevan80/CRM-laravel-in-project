<?php

namespace App\Http\Livewire\Manage;

use Livewire\Component;

class Categories extends Component
{
    public $categories;

    public function mount($categories) {
        $this->fill(['categories' => $categories]);
    }

    public function render()
    {
        return view('livewire.manage.categories');
    }
}
