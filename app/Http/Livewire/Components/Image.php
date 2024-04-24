<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Image extends Component
{
    public $image;

    public function save()

    {

        $this->validate([

            'photo' => 'image|max:1024', // 1MB Max

        ]);



        $this->photo->store('photos');

    }

    public function render()
    {
        return view('livewire.components.image');
    }
}
