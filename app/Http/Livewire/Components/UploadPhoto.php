<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadPhoto extends Component
{

    use withFileUploads;

    public $image = false;


    protected function rules()
    {
        if ($this->image instanceof \Illuminate\Http\UploadedFile) {

            $rules['image'] = 'required|image|mimes:jpg,jpeg,png,svg,gif,webp|max:204800';
        } else {
            $rules['image'] = 'required|string|min:1|max:255';
        }
        return $rules;
    }

    public function render()
    {
        return view('livewire.components.upload-photo');
    }
}
